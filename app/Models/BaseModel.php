<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{
    protected static function booted()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->user_id = Auth::id(); // directly assign karo
            }
        });

        static::addGlobalScope('user', function ($builder) {
            if (Auth::check()) {
                $builder->where('user_id', Auth::id());
            }
        });
    }

}
