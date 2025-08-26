<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'tbl_danhmuc';
    protected $primaryKey = 'ma_danhmuc';

    protected $fillable = [
        'ten_danhmuc',
        'hinh_anh',
        'mo_ta',
    ];

    /**
     * Relationships
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'ma_danhmuc', 'ma_danhmuc');
    }

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'iddm', 'ma_danhmuc');
    }

    /**
     * Accessors
     */
    public function getProductCountAttribute(): int
    {
        return $this->products()->count();
    }

    public function getInStockProductCountAttribute(): int
    {
        return $this->products()->inStock()->count();
    }

    public function getImageUrlAttribute(): string
    {
        return $this->hinh_anh ? asset('storage/uploads/' . $this->hinh_anh) : asset('images/default-category.jpg');
    }

    /**
     * Scopes
     */
    public function scopeWithProducts($query)
    {
        return $query->has('products');
    }

    public function scopeWithInStockProducts($query)
    {
        return $query->whereHas('products', function ($query) {
            $query->inStock();
        });
    }

    /**
     * Methods
     */
    public function getFeaturedProducts(int $limit = 6)
    {
        return $this->products()
            ->featured()
            ->inStock()
            ->limit($limit)
            ->get();
    }

    public function getPopularProducts(int $limit = 6)
    {
        return $this->products()
            ->popular()
            ->inStock()
            ->limit($limit)
            ->get();
    }
}
