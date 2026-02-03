<?php

namespace App\Models;

use App\Models\BaseModel;

class BillingItem extends BaseModel
{
    protected $fillable = ['user_id','billing_id', 'product_id', 'quantity', 'price','gst_percent','gst_amount','total'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function invoice() {
        return $this->belongsTo(Billing::class);
    }

    public function serials(){
        return $this->hasMany(BillItemSerial::class);
    }
}
