<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryStock extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_detail_id',
        'stock',
    ];

    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class);
    }


}
