<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCategory;
use App\SubCategoryTranslation;
use App\SubSubCategory;
use App\Category;
use App\Product;
use App\Language;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search =null;
        $subcategories = SubCategory::orderBy('created_at', 'desc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $subcategories = $subcategories->where('name', 'like', '%'.$sort_search.'%');
        }
        $subcategories = $subcategories->paginate(15);
        return view('backend.product.subcategories.index', compact('subcategories', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('backend.product.subcategories.create', compact('categories'));
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
            $subcategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        }
        else {
            $subcategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);
        }

        $subcategory->save();

        $sub_category_translation = SubCategoryTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'sub_category_id' => $subcategory->id]);
        $sub_category_translation->name = $request->name;
        $sub_category_translation->save();

        flash(translate('Subcategory has been inserted successfully'))->success();
        return redirect()->route('subcategories.index');

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
        $subcategory    = SubCategory::findOrFail($id);
        $categories     = Category::all();
        return view('backend.product.subcategories.edit', compact('categories', 'subcategory','lang'));
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
        if($request->lang == env("DEFAULT_LANGUAGE")){
            $subcategory->name = $request->name;
        }
        $subcategory->category_id = $request->category_id;
        $subcategory->meta_title = $request->meta_title;
        $subcategory->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $subcategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        }
        else {
            $subcategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);
        }

        $subcategory->save();

        $sub_category_translation = SubCategoryTranslation::firstOrNew(['lang' => $request->lang, 'sub_category_id' => $subcategory->id]);
        $sub_category_translation->name = $request->name;
        $sub_category_translation->save();

        flash(translate('Subcategory has been updated successfully'))->success();
        return redirect()->route('subcategories.index');

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
        // Sub Subcategories delete
        foreach ($subcategory->subsubcategories as $key => $subsubcategory) {
            // Sub Subcategories Translations delete
            foreach ($subsubcategory->sub_sub_category_translations as $key => $sub_sub_category_translation) {
                $sub_sub_category_translation->delete();
            }
            $subsubcategory->delete();
        }
        // Sub categories Translations delete
        foreach ($subcategory->sub_category_translations as $key => $sub_category_translation) {
            $sub_category_translation->delete();
        }

        Product::where('subcategory_id', $subcategory->id)->delete();
        SubCategory::destroy($id);

        flash(translate('Subcategory has been deleted successfully'))->success();
        return redirect()->route('subcategories.index');
    }


    public function get_subcategories_by_category(Request $request)
    {
        $subcategories = SubCategory::where('category_id', $request->category_id)->get();
        return $subcategories;
    }
}
