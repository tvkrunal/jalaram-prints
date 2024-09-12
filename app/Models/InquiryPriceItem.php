<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PriceMaster;

class InquiryPriceItem extends Model
{
    use HasFactory;

    protected $table = 'inquiry_price_items';

    protected $guarded = ['id'];


    public function priceMaster()
    {
        return $this->belongsTo(PriceMaster::class, 'price_master_id');
    }
}
