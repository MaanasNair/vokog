<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class SubCategory extends Model
{
    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $sub_category_translation = $this->hasMany(SubCategoryTranslation::class)->where('lang', $lang)->first();
        return $sub_category_translation != null ? $sub_category_translation->$field : $this->$field;
    }

    public function category(){
    	return $this->belongsTo(Category::class);
    }

    public function subsubcategories(){
    	return $this->hasMany(SubSubCategory::class);
    }

    public function products(){
      return $this->hasMany(Product::class, 'subcategory_id');
    }

    public function classified_products(){
    	return $this->hasMany(CustomerProduct::class, 'subcategory_id');
    }

    public function sub_category_translations(){
      return $this->hasMany(SubCategoryTranslation::class);
    }

}
