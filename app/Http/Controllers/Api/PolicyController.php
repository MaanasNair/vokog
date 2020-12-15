<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PolicyCollection;
use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function sellerPolicy()
    {
        return new PolicyCollection(Policy::where('name', 'seller_policy')->get());
    }

    public function supportPolicy()
    {
        return new PolicyCollection(Policy::where('name', 'support_policy')->get());
    }

    public function returnPolicy()
    {
        return new PolicyCollection(Policy::where('name', 'return_policy')->get());
    }
}
