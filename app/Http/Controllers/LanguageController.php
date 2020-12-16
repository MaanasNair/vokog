<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use File;
use App\Language;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request)
    {
    	$request->session()->put('locale', $request->locale);
        $language = Language::where('code', $request->locale)->first();
    	flash(__('Language changed to ').$language->name)->success();
    }

    public function index(Request $request)
    {
        $languages = Language::all();
        return view('business_settings.languages.index', compact('languages'));
    }

    public function create(Request $request)
    {
        return view('business_settings.languages.create');
    }

    public function store(Request $request)
    {
        $language = new Language;
        $language->name = $request->name;
        $language->code = $request->code;
        if($language->save()){
            saveJSONFile($language->code, openJSONFile('en'));
            flash(__('Language has been inserted successfully'))->success();
            return redirect()->route('languages.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function show($id)
    {
        $language = Language::findOrFail(decrypt($id));
        return view('business_settings.languages.language_view', compact('language'));
    }

    public function edit($id)
    {
        $language = Language::findOrFail(decrypt($id));
        return view('business_settings.languages.edit', compact('language'));
    }

    public function update(Request $request, $id)
    {
        $language = Language::findOrFail($id);
        $language->name = $request->name;
        $language->code = $request->code;
        if($language->save()){
            flash(__('Language has been updated successfully'))->success();
            return redirect()->route('languages.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function key_value_store(Request $request)
    {
        $language = Language::findOrFail($request->id);
        $data = openJSONFile($language->code);
        foreach ($request->key as $key => $key) {
            $data[$key] = $request->key[$key];
        }
        saveJSONFile($language->code, $data);
        flash(__('Key-Value updated  for ').$language->name)->success();
        return back();
    }

    public function update_rtl_status(Request $request)
    {
        $language = Language::findOrFail($request->id);
        $language->rtl = $request->status;
        if($language->save()){
            flash(__('RTL status updated successfully'))->success();
            return 1;
        }
        return 0;
    }

    public function destroy($id)
    {
        if(Language::destroy($id)){
            flash(__('Language has been deleted successfully'))->success();
            return redirect()->route('languages.index');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }
}
