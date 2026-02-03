<?php

namespace App\Models;

use App\Models\BaseModel;

class Supplier extends BaseModel
{
   protected $fillable = ['user_id','name','email','contact'];
}
