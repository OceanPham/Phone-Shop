<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'tbl_coupon';
    protected $primaryKey = 'coupon_id';

    protected $fillable = [
        'coupon_name',
        'coupon_code',
        'coupon_number',
        'coupon_condition',
        'coupon_value',
        'coupon_start_time',
        'coupon_end_time',
        'coupon_status',
        'coupon_desc',
    ];

    protected function casts(): array
    {
        return [
            'coupon_start_time' => 'datetime',
            'coupon_end_time' => 'datetime',
            'coupon_condition' => 'integer',
            'coupon_value' => 'decimal:2',
            'coupon_number' => 'integer',
            'coupon_status' => 'boolean',
        ];
    }

    /**
     * Accessors
     */
    public function getIsValidAttribute(): bool
    {
        return $this->coupon_status &&
            $this->coupon_start_time <= now() &&
            $this->coupon_end_time >= now() &&
            $this->coupon_number > 0;
    }

    public function getIsFixedAmountAttribute(): bool
    {
        return $this->coupon_condition == 1; // 1 = fixed amount, 2 = percentage
    }

    public function getIsPercentageAttribute(): bool
    {
        return $this->coupon_condition == 2;
    }

    public function getFormattedValueAttribute(): string
    {
        if ($this->is_percentage) {
            return $this->coupon_value . '%';
        }
        return number_format($this->coupon_value, 0, ',', '.') . ' VND';
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('coupon_status', true)
            ->where('coupon_start_time', '<=', now())
            ->where('coupon_end_time', '>=', now())
            ->where('coupon_number', '>', 0);
    }

    public function scopeExpired($query)
    {
        return $query->where('coupon_end_time', '<', now());
    }

    public function scopeUsedUp($query)
    {
        return $query->where('coupon_number', '<=', 0);
    }

    /**
     * Methods
     */
    public function canUse(): bool
    {
        return $this->is_valid;
    }

    public function use(): bool
    {
        if (!$this->canUse()) {
            return false;
        }

        $this->decrement('coupon_number');
        return true;
    }

    public function calculateDiscount(float $orderTotal): float
    {
        if (!$this->canUse()) {
            return 0;
        }

        if ($this->is_percentage) {
            return $orderTotal * ($this->coupon_value / 100);
        }

        return min($this->coupon_value, $orderTotal);
    }
}
