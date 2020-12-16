<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
  public function category(){
  	return $this->belongsTo(Category::class);
  }

  public function subsubcategories(){
  	return $this->hasMany(SubSubCategory::class);
  }
}
