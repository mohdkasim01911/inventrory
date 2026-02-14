<?php

namespace App\Models;

use App\Models\BaseModel;

class Product extends BaseModel
{
    protected $fillable = ['user_id','name','category_id','ampere','price','stock','serial_number','date','month'];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
