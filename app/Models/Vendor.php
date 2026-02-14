<?php

namespace App\Models;

use App\Models\BaseModel;

class Vendor extends BaseModel
{
     protected $fillable = ['user_id','name','email','phone','gst_number','address','pan','adhar'];
}
