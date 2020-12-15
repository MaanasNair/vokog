<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SubCategoryCollection;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    public function index($id)
    {
        return new SubCategoryCollection(SubCategory::where('category_id', $id)->get());
    }
}
