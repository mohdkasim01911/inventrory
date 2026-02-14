<?php

namespace App\Models;

use App\Models\BaseModel;

class Employee extends BaseModel
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'salary',
        'pan',
        'adhar',
    ];

    public function monthAmounts()
    {
        return $this->hasMany(EmployeeMonthAmount::class, 'employee_id');
    }

}
