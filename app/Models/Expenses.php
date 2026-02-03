<?php

namespace App\Models;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class Expenses extends BaseModel
{
    protected $fillable = ['user_id','title', 'name', 'amount', 'description'];
}
