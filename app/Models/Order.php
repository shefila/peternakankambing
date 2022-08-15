<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipping_address',
        'shipping',
        'number',
        'status',
    ];

    const STATUS_OPTION = [
        'draft',
        'pending_payment',
        'success_payment',
        'done',
    ];

    public function nextStatus()
    {
        $index = 0;
        foreach (self::STATUS_OPTION as $i => $item) {
            if ($item == $this['status']) {
                $index = $i;
                break;
            }
        }

        return self::STATUS_OPTION[$index + 1];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getTotalItemAttribute()
    {
        return $this->orderDetails()->count();
    }

    public function getTotalWeightAttribute()
    {
        return $this->orderDetails()->sum('amount');
    }

    public function totalShippingPrice()
    {
        $weight = $this->orderDetails()->sum('amount');
        return $weight;
    }

    public function getTotalShippingPriceAttribute()
    {
        return formatPrice($this->totalShippingPrice());
    }

    public function getAmountAttribute()
    {
        return formatPrice($this->amount());
    }

    public function getModalAttribute()
    {
        return formatPrice($this->modal());
    }

    public function getUntungAttribute()
    {
        return formatPrice(($this->amount() - $this->modal()));

    }

    public function amount()
    {
        $total = 0;
        foreach ($this->orderDetails()->get() as $orderDetail) {
            $total += $orderDetail['amount'] * $orderDetail['price'];
        }

        return $total;
    }

    public function getTotalPaymentAttribute()
    {
        return formatPrice($this->amount() - $this->saldo());

    }

    public function getSaldoAttribute()
    {
        return formatPrice($this->saldo());
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function saldo()
    {
        if($this->transaction()->exists()){
            return $this->transaction['amount'];
        } else {
            return 0;
        }
    }

    public function modal()
    {
        $total = 0;
        foreach ($this->orderDetails()->get() as $orderDetail) {
            $total += $orderDetail['amount'] * $orderDetail['buy_price'];
        }

        return $total;
    }
}
