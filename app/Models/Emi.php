<?php

namespace App\Models;

use App\Models\BaseModel;

class Emi extends BaseModel
{
     protected $fillable = [
        'user_id','billing_id', 'customer_id', 'total_amount',
        'installments', 'installment_amount',
        'paid_amount', 'due_amount', 'next_due_date', 'status','paid_date'
    ];

    public function sale()
    {
        return $this->belongsTo(Billing::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
