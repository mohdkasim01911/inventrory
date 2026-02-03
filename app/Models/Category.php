<?php

namespace App\Models;

use App\Models\BaseModel;

class Category extends BaseModel
{
    protected $fillable = ['user_id','name', 'slug', 'user_id'];

    // Relation for products (important for cascade delete)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
