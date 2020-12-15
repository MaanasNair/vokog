<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SliderCollection;
use App\Models\Slider;

class SliderController extends Controller
{
    public function index()
    {
        return new SliderCollection(Slider::all());
    }
}
