<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Customer;
use App\Models\InquiryProcess;

class Inquiry extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inquiries';

    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function processes()
    {
        return $this->hasMany(InquiryProcess::class,'inquiry_id');
    }

    public function inquiryPriceItems()
    {
        return $this->hasMany(InquiryPriceItem::class, 'inquiry_id');
    }
}
