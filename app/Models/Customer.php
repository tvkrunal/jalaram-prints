<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;


class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customers';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFullNameAttribute()
    {
        return preg_replace('/\s+/', ' ', $this->customer_first_name . ' ' . $this->customer_last_name);
    }
}
