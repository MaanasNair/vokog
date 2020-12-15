<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class SubSubCategory extends Model
{
    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false? App::getLocale() : $lang;
        $sub_sub_category_translation = $this->hasMany(SubSubCategoryTranslation::class)->where('lang', $lang)->first();
        return $sub_sub_category_translation != null ? $sub_sub_category_translation->$field : $this->$field;
    }

    public function subcategory(){
    	return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function products(){
    	return $this->hasMany(Product::class, 'subsubcategory_id');
    }

    public function classified_products(){
    	return $this->hasMany(CustomerProduct::class, 'subsubcategory_id');
    }

    public function sub_sub_category_translations(){
      return $this->hasMany(SubSubCategoryTranslation::class);
    }
}
