<?php

namespace App\Models;


use App\Models\BaseModel;

class BillItemSerial extends BaseModel
{
    protected $fillable = ['user_id','billing_item_id','serial_number'];

    public function item()
    {
        return $this->belongsTo(BillingItem::class, 'billing_item_id');
    }

}
