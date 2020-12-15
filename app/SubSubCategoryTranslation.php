<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubSubCategoryTranslation extends Model
{
    protected $fillable = ['name', 'lang', 'sub_sub_category_id'];

    public function sub_sub_category(){
    	return $this->belongsTo(SubSubCategory::class);
    }
}
