<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryProcess extends Model
{
    use HasFactory;

    protected $table = 'inquiry_processes';

    protected $guarded = ['id'];
}
