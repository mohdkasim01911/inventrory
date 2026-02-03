<?php

namespace App\Models;

use App\Models\BaseModel;

class Payable extends BaseModel
{
   protected $fillable = [
        'user_id',
        'customer_id',
        'amount',
        'due_date',
        'status',
        'remarks',
        'pay_amount',
        'due_amount'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
