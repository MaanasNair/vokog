<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubSubCategory;
use App\Brand;
use App\Product;
use App\Language;

class SubSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subsubcategories = SubSubCategory::all();
        return view('subsubcategories.index', compact('subsubcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('subsubcategories.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subsubcategory = new SubSubCategory;
        $subsubcategory->name = $request->name;
        $subsubcategory->sub_category_id = $request->sub_category_id;

        $subsubcategory->brands = json_encode($request->brands);
        $subsubcategory->meta_title = $request->meta_title;
        $subsubcategory->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $subsubcategory->slug = str_replace(' ', '-', $request->slug);
        }
        else {
            $subsubcategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.str_random(5);
        }

        $data = openJSONFile('en');
        $data[$subsubcategory->name] = $subsubcategory->name;
        saveJSONFile('en', $data);

        if($subsubcategory->save()){
            flash(__('SubSubCategory has been inserted successfully'))->success();
            return redirect()->route('subsubcategories.index');
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
        $subsubcategory = SubSubCategory::findOrFail(decrypt($id));
        $categories = Category::all();
        $brands = Brand::all();
        return view('subsubcategories.edit', compact('subsubcategory', 'categories', 'brands'));
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
        $subsubcategory = SubSubCategory::findOrFail($id);

        foreach (Language::all() as $key => $language) {
            $data = openJSONFile($language->code);
            unset($data[$subsubcategory->name]);
            $data[$request->name] = "";
            saveJSONFile($language->code, $data);
        }

        $subsubcategory->name = $request->name;
        $subsubcategory->sub_category_id = $request->sub_category_id;

        $subsubcategory->brands = json_encode($request->brands);
        $subsubcategory->meta_title = $request->meta_title;
        $subsubcategory->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $subsubcategory->slug = str_replace(' ', '-', $request->slug);
        }
        else {
            $subsubcategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.str_random(5);
        }

        if($subsubcategory->save()){
            flash(__('SubSubCategory has been updated successfully'))->success();
            return redirect()->route('subsubcategories.index');
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
        $subsubcategory = SubSubCategory::findOrFail($id);
        Product::where('subsubcategory_id', $subsubcategory->id)->delete();
        if(SubSubCategory::destroy($id)){
            foreach (Language::all() as $key => $language) {
                $data = openJSONFile($language->code);
                unset($data[$subsubcategory->name]);
                saveJSONFile($language->code, $data);
            }
            flash(__('SubSubCategory has been deleted successfully'))->success();
            return redirect()->route('subsubcategories.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function get_subsubcategories_by_subcategory(Request $request)
    {
        $subsubcategories = SubSubCategory::where('sub_category_id', $request->subcategory_id)->get();
        return $subsubcategories;
    }

    public function get_brands_by_subsubcategory(Request $request)
    {
        $brand_ids = json_decode(SubSubCategory::findOrFail($request->subsubcategory_id)->brands);
        $brands = array();
        foreach ($brand_ids as $key => $brand_id) {
            array_push($brands, Brand::findOrFail($brand_id));
        }
        return $brands;
    }
}
