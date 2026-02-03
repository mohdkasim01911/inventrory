<?php

namespace App\Models;

use App\Models\BaseModel;

class PurchaseItem extends BaseModel
{
    protected $fillable = [
        'user_id','purchase_id','product_id','quantity',
        'price','gst_percent','gst_amount','total'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
