<?php

namespace App\Models;

use App\Models\BaseModel;

class PayableLog extends BaseModel
{
    protected $fillable = ['user_id','payable_id','pay_amount','due_amount'];
}
