<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'tbl_order_detail';

    protected $fillable = [
        'idsanpham',
        'iddonhang',
        'soluong',
        'dongia',
        'tensp',
        'hinhanh',
        'ma_danhmuc',
    ];

    protected function casts(): array
    {
        return [
            'dongia' => 'decimal:2',
        ];
    }

    /**
     * Relationships
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'iddonhang');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'idsanpham', 'masanpham');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'ma_danhmuc', 'ma_danhmuc');
    }

    /**
     * Accessors
     */
    public function getTotalAttribute(): float
    {
        return $this->soluong * $this->dongia;
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->dongia) . ' VND';
    }

    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total) . ' VND';
    }

    public function getImageUrlAttribute(): string
    {
        return $this->hinhanh ? asset('storage/uploads/' . $this->hinhanh) : asset('images/default-product.jpg');
    }
}
