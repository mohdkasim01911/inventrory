<?php

namespace App\Models;

use App\Models\BaseModel;

class PurchaseSerial extends BaseModel
{
    protected $fillable = ['user_id','purchase_id','product_id','serial_number','status'];
}
