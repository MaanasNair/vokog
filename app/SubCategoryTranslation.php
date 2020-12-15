<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategoryTranslation extends Model
{
    protected $fillable = ['name', 'lang', 'sub_category_id'];

    public function sub_category(){
    	return $this->belongsTo(SubCategory::class);
    }
}
