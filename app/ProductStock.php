<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    //
    public function product(){
    	return $this->belongsTo(Product::class);
    }
}
