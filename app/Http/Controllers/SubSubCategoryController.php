<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubSubCategory;
use App\SubSubCategoryTranslation;
use App\Brand;
use App\Product;
use App\Language;
use Illuminate\Support\Str;

class SubSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search =null;
        $subsubcategories = SubSubCategory::orderBy('created_at', 'desc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $subsubcategories = $subsubcategories->where('name', 'like', '%'.$sort_search.'%');
        }
        $subsubcategories = $subsubcategories->paginate(15);
        return view('backend.product.subsubcategories.index', compact('subsubcategories', 'sort_search'));
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
        return view('backend.product.subsubcategories.create', compact('categories', 'brands'));
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
        $subsubcategory->meta_title = $request->meta_title;
        $subsubcategory->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $subsubcategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        }
        else {
            $subsubcategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);
        }
        $subsubcategory->save();

        $sub_sub_category_translation = SubSubCategoryTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'sub_sub_category_id' => $subsubcategory->id]);
        $sub_sub_category_translation->name = $request->name;
        $sub_sub_category_translation->save();


        flash(translate('SubSubCategory has been inserted successfully'))->success();
        return redirect()->route('subsubcategories.index');

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
    public function edit(Request $request, $id)
    {
        $lang           = $request->lang;
        $subsubcategory = SubSubCategory::findOrFail($id);
        $categories     = Category::all();
        $brands         = Brand::all();
        return view('backend.product.subsubcategories.edit', compact('subsubcategory', 'categories', 'brands','lang'));
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
        if($request->lang == env("DEFAULT_LANGUAGE")){
            $subsubcategory->name = $request->name;
        }
        $subsubcategory->sub_category_id = $request->sub_category_id;
        $subsubcategory->meta_title = $request->meta_title;
        $subsubcategory->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $subsubcategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        }
        else {
            $subsubcategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);
        }

        $subsubcategory->save();

        $sub_sub_category_translation = SubSubCategoryTranslation::firstOrNew(['lang' => $request->lang, 'sub_sub_category_id' => $subsubcategory->id]);
        $sub_sub_category_translation->name = $request->name;
        $sub_sub_category_translation->save();

        flash(translate('SubSubCategory has been updated successfully'))->success();
        return redirect()->route('subsubcategories.index');
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

        foreach ($subsubcategory->sub_sub_category_translations as $key => $sub_sub_category_translation) {
            $sub_sub_category_translation->delete();
        }

        SubSubCategory::destroy($id);

        flash(translate('SubSubCategory has been deleted successfully'))->success();
        return redirect()->route('subsubcategories.index');
    }

    public function get_subsubcategories_by_subcategory(Request $request)
    {
        $subsubcategories = SubSubCategory::where('sub_category_id', $request->subcategory_id)->get();
        return $subsubcategories;
    }
}
