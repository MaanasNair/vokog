<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCategory;
use App\SubSubCategory;
use App\Category;
use App\Product;
use App\Language;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = SubCategory::all();
        return view('subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subcategory = new SubCategory;
        $subcategory->name = $request->name;
        $subcategory->category_id = $request->category_id;
        $subcategory->meta_title = $request->meta_title;
        $subcategory->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $subcategory->slug = str_replace(' ', '-', $request->slug);
        }
        else {
            $subcategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.str_random(5);
        }

        $data = openJSONFile('en');
        $data[$subcategory->name] = $subcategory->name;
        saveJSONFile('en', $data);

        if($subcategory->save()){
            flash(__('Subcategory has been inserted successfully'))->success();
            return redirect()->route('subcategories.index');
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
        $subcategory = SubCategory::findOrFail(decrypt($id));
        $categories = Category::all();
        return view('subcategories.edit', compact('categories', 'subcategory'));
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
        $subcategory = SubCategory::findOrFail($id);

        foreach (Language::all() as $key => $language) {
            $data = openJSONFile($language->code);
            unset($data[$subcategory->name]);
            $data[$request->name] = "";
            saveJSONFile($language->code, $data);
        }

        $subcategory->name = $request->name;
        $subcategory->category_id = $request->category_id;
        $subcategory->meta_title = $request->meta_title;
        $subcategory->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $subcategory->slug = str_replace(' ', '-', $request->slug);
        }
        else {
            $subcategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.str_random(5);
        }

        if($subcategory->save()){
            flash(__('Subcategory has been updated successfully'))->success();
            return redirect()->route('subcategories.index');
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
        $subcategory = SubCategory::findOrFail($id);
        foreach ($subcategory->subsubcategories as $key => $subsubcategory) {
            $subsubcategory->delete();
        }
        Product::where('subcategory_id', $subcategory->id)->delete();
        if(SubCategory::destroy($id)){
            foreach (Language::all() as $key => $language) {
                $data = openJSONFile($language->code);
                unset($data[$subcategory->name]);
                saveJSONFile($language->code, $data);
            }
            flash(__('Subcategory has been deleted successfully'))->success();
            return redirect()->route('subcategories.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }


    public function get_subcategories_by_category(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->category_id)->get();
        return $subcategories;
    }
}
