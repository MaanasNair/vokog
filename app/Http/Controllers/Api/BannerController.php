<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BannerCollection;
use App\Models\Banner;

class BannerController extends Controller
{

    public function index()
    {
        return new BannerCollection(Banner::all());
    }
}
