<?php

namespace App\Models;

use App\Models\BaseModel;

class Employee extends BaseModel
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'salary',
    ];

}
