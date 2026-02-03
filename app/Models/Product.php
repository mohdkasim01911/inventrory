<?php

namespace App\Models;

use App\Models\BaseModel;

class Product extends BaseModel
{
    protected $fillable = ['user_id','name','category_id','price','stock','serial_number'];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
