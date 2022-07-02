<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Saving extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'target',
        'due_date',
        'period',
    ];

    protected $dates = [
        'due_date'
    ];

    const PERIOD_DAILY = 'daily';
    const PERIOD_WEEKLY = 'weekly';
    const PERIOD_MONTHLY = 'monthly';

    const PERIODS = [
        'Harian' => self::PERIOD_DAILY,
        'Mingguan' => self::PERIOD_WEEKLY,
        'Bulanan' => self::PERIOD_MONTHLY,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    private function total()
    {
        return $this->transactions()
            ->where('category', Transaction::CATEGORY_DEPOSIT)
            ->where('status', Transaction::STATUS_SUCCESS)
            ->sum('amount');
    }

    public function getTotalAttribute()
    {
        return $this->total();
    }

    public function getCountDownAttribute()
    {
        if (now() > $this['due_date']) {
            return 'Target tidak tercapai';
        } else {
            if ($this->progressPercent() >= 100) {
                return 'Target sudah tercapai';
            } else {
                if ($this['period'] === self::PERIOD_DAILY) {
                    return now()->diffInDays($this['due_date']) . ' hari lagi';
                } else if ($this['period'] === self::PERIOD_WEEKLY) {
                    return now()->diffInWeeks($this['due_date']) . ' minggu lagi';
                } else if ($this['period'] === self::PERIOD_MONTHLY) {
                    return now()->diffInMonths($this['due_date']) . ' bulan lagi';
                } else {
                    return null;
                }
            }
        }
    }

    public function getTransPeriodAttribute()
    {
        $period = null;
        foreach (self::PERIODS as $name => $PERIOD) {
            if ($this['period'] === $PERIOD) {
                $period = $name;
                break;
            }
        }
        return $period;
    }

    public function getRecommendationAmountAttribute()
    {
        $total = $this->total();
        $remainAmount = $this['target'] - $total;
        $remainTime = 0;
        if ($this['period'] === self::PERIOD_DAILY) {
            $remainTime = now()->diffInDays($this['due_date']);
        } else if ($this['period'] === self::PERIOD_WEEKLY) {
            $remainTime = now()->diffInWeeks($this['due_date']);
        } else if ($this['period'] === self::PERIOD_MONTHLY) {
            $remainTime = now()->diffInMonths($this['due_date']);
        }

        return $remainAmount / $remainTime;
    }

    public function getProgressPercentAttribute()
    {
        return $this->progressPercent() > 100 ? 100 : $this->progressPercent();
    }

    public function progressPercent()
    {
        return round($this->total() / $this['target'] * 100, 2);
    }
}

