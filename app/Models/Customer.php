<?php

namespace App\Models;

use App\Models\BaseModel;

class Customer extends BaseModel
{
    protected $fillable = ['user_id','name', 'contact', 'email','pan','adhar'];

    public function udhars()
    {
        return $this->hasMany(Udhar::class);
    }
}
