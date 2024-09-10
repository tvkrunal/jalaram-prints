<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inquiry;

class InquiryBilling extends Model
{
    use HasFactory;

    protected $table = 'inquiry_billings';

    protected $guarded = ['id'];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'inquiry_id');
    }
}
