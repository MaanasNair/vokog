<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HomeCategory;
use App\Category;

class HomeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $home_categories = HomeCategory::all();
        return view('home_categories.index', compact('home_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $home_category = new HomeCategory;
        $home_category->category_id = $request->category_id;
        $home_category->subsubcategories = json_encode($request->subsubcategories);
        if($home_category->save()){
            flash(__('Home Page Category has been inserted successfully'))->success();
            return redirect()->route('home_settings.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
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
        $homeCategory = HomeCategory::findOrFail($id);
        return view('home_categories.edit', compact('homeCategory'));
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
        $home_category = HomeCategory::findOrFail($id);
        $home_category->category_id = $request->category_id;
        $home_category->subsubcategories = json_encode($request->subsubcategories);
        if($home_category->save()){
            flash(__('Home Page Category has been inserted successfully'))->success();
            return redirect()->route('home_settings.index');
        }

        flash(__('Something went wrong'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(HomeCategory::destroy($id)){
            flash(__('Home Page Category has been deleted successfully'))->success();
            return redirect()->route('home_settings.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function update_status(Request $request)
    {
        $home_category = HomeCategory::findOrFail($request->id);
        $home_category->status = $request->status;
        if($home_category->save()){
            return 1;
        }
        return 0;
    }

    public function getSubSubCategories(Request $request)
    {
        $result = array();
        $subcategories = Category::find($request->category_id)->subcategories;
        foreach ($subcategories as $key => $subcategory) {
            foreach ($subcategory->subsubcategories as $key => $subsubcategory) {
                $subsubcategory['number_of_products'] = count($subsubcategory->products);
                array_push($result, $subsubcategory);
            }
        }
        return $result;
    }
}
