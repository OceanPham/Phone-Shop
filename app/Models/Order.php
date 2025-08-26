<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'tbl_order';

    protected $fillable = [
        'madonhang',
        'tongdonhang',
        'pttt',
        'iduser',
        'name',
        'dienThoai',
        'address',
        'ghichu',
        'timeorder',
        'trangthai',
        'thanhtoan',
        'coupon_code',
        'shipping_fee',
        'vat_fee',
        'email',
    ];

    protected function casts(): array
    {
        return [
            'timeorder' => 'datetime',
            'tongdonhang' => 'decimal:2',
            'shipping_fee' => 'decimal:2',
            'vat_fee' => 'decimal:2',
            'thanhtoan' => 'boolean',
        ];
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'iddonhang');
    }

    /**
     * Accessors
     */
    public function getStatusTextAttribute(): string
    {
        $statuses = [
            1 => 'Chờ xác nhận',
            2 => 'Đã xác nhận',
            3 => 'Đang giao hàng',
            4 => 'Hoàn thành',
            5 => 'Giao hàng thất bại',
            6 => 'Đã hủy'
        ];
        return $statuses[$this->trangthai] ?? 'Không xác định';
    }

    public function getPaymentStatusTextAttribute(): string
    {
        return $this->thanhtoan ? 'Đã thanh toán' : 'Chưa thanh toán';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        $classes = [
            1 => 'bg-yellow-100 text-yellow-800',
            2 => 'bg-blue-100 text-blue-800',
            3 => 'bg-purple-100 text-purple-800',
            4 => 'bg-green-100 text-green-800',
            5 => 'bg-red-100 text-red-800',
            6 => 'bg-gray-100 text-gray-800'
        ];
        return $classes[$this->trangthai] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('trangthai', 1);
    }



    public function scopeConfirmed($query)
    {
        return $query->where('trangthai', 2);
    }

    public function scopeShipping($query)
    {
        return $query->where('trangthai', 3);
    }

    public function scopeCompleted($query)
    {
        return $query->where('trangthai', 4);
    }

    public function scopeFailed($query)
    {
        return $query->where('trangthai', 5);
    }

    public function scopeCancelled($query)
    {
        return $query->where('trangthai', 6);
    }

    public function scopePaid($query)
    {
        return $query->where('thanhtoan', true);
    }

    public function scopeUnpaid($query)
    {
        return $query->where('thanhtoan', false);
    }

    /**
     * Methods
     */
    public function canCancel(): bool
    {
        return in_array($this->trangthai, [1, 2]);
    }

    public function canUpdate(): bool
    {
        return $this->trangthai < 4;
    }

    public function getTotalItemsAttribute(): int
    {
        return $this->orderDetails()->sum('soluong');
    }
}
