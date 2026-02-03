<?php

namespace App\Models;
use App\Models\BaseModel;

class EmiLog extends BaseModel
{
    protected $fillable = ['user_id','emi_id', 'installment_amount', 'paid_amount','due_amount'];
}
