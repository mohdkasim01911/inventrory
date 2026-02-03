<?php

namespace App\Models;

use App\Models\BaseModel;

class EmployeeMonthAmount extends BaseModel
{
    protected $fillable = [
        'user_id',
        'employee_id',
        'amount',
        'details',
    ];
}
