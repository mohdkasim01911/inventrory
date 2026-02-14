<?php

namespace App\Models;

use App\Models\BaseModel;

class Billing extends BaseModel
{
    protected $fillable = ['user_id','customer_id', 'total_amount', 'tax', 'discount','gst_amount','subtotal','cash','details','date'];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function items() {
        return $this->hasMany(BillingItem::class);
    }

    public function emis()
    {
        return $this->hasMany(Emi::class);
    }
}
