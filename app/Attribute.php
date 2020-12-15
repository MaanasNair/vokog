<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    public function getTranslation($field = '', $lang = false){
      $lang = $lang == false ? env('DEFAULT_LANGUAGE') : $lang;
      $attribute_translation = $this->hasMany(AttributeTranslation::class)->where('lang', $lang)->first();
      return $attribute_translation != null ? $attribute_translation->$field : $this->$field;
    }

    public function attribute_translations(){
      return $this->hasMany(AttributeTranslation::class);
    }

}
