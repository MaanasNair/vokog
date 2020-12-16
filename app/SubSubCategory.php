<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubSubCategory extends Model
{
  public function subcategory(){
  	return $this->belongsTo(SubCategory::class, 'sub_category_id');
  }

  public function products(){
  	return $this->hasMany(Product::class, 'subsubcategory_id');
  }
}
