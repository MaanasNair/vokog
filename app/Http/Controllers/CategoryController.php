<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\HomeCategory;
use App\Product;
use App\Language;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $category->slug = str_replace(' ', '-', $request->slug);
        }
        else {
            $category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.str_random(5);
        }

        $data = openJSONFile('en');
        $data[$category->name] = $category->name;
        saveJSONFile('en', $data);

        if($request->hasFile('banner')){
            $category->banner = $request->file('banner')->store('uploads/categories/banner');
        }
        if($request->hasFile('icon')){
            $category->icon = $request->file('icon')->store('uploads/categories/icon');
        }

        if($category->save()){
            flash(__('Category has been inserted successfully'))->success();
            return redirect()->route('categories.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail(decrypt($id));
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        foreach (Language::all() as $key => $language) {
            $data = openJSONFile($language->code);
            unset($data[$category->name]);
            $data[$request->name] = "";
            saveJSONFile($language->code, $data);
        }

        $category->name = $request->name;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $category->slug = str_replace(' ', '-', $request->slug);
        }
        else {
            $category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.str_random(5);
        }

        if($request->hasFile('banner')){
            $category->banner = $request->file('banner')->store('uploads/categories/banner');
        }
        if($request->hasFile('icon')){
            $category->icon = $request->file('icon')->store('uploads/categories/icon');
        }

        if($category->save()){
            flash(__('Category has been updated successfully'))->success();
            return redirect()->route('categories.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        foreach ($category->subcategories as $key => $subcategory) {
            foreach ($subcategory->subsubcategories as $key => $subsubcategory) {
                $subsubcategory->delete();
            }
            $subcategory->delete();
        }

        Product::where('category_id', $category->id)->delete();
        HomeCategory::where('category_id', $category->id)->delete();

        if(Category::destroy($id)){
            foreach (Language::all() as $key => $language) {
                $data = openJSONFile($language->code);
                unset($data[$category->name]);
                saveJSONFile($language->code, $data);
            }

            if($category->banner != null){
                //($category->banner);
            }
            if($category->icon != null){
                //unlink($category->icon);
            }
            flash(__('Category has been deleted successfully'))->success();
            return redirect()->route('categories.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function updateFeatured(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->featured = $request->status;
        if($category->save()){
            return 1;
        }
        return 0;
    }
}
