<?php

namespace App\Models;

use App\Models\BaseModel;

class Purchase extends BaseModel
{
   protected $fillable = [
        'user_id','vendor_id','invoice_no','invoice_date',
        'subtotal','gst_amount','total_amount'
    ];

    public function items(){
        return $this->hasMany(PurchaseItem::class);
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class);
    }

    public function serials()
    {
        return $this->hasMany(PurchaseSerial::class);
    }
}
