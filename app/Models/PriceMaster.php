<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceMaster extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'price_masters';

    protected $guarded = ['id'];
}
