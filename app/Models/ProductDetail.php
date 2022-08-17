<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'detail',
        'price',
        'stock',
        'buy_price',
        'description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getFormattedPriceAttribute()
    {
        return formatPrice($this['price']);
    }
    public function historyStocks()
    {
        return $this->hasMany(HistoryStock::class);
    }
}
