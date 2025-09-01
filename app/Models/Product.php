<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use HasFactory;

    protected $table = 'tbl_sanpham';
    protected $primaryKey = 'masanpham';

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'masanpham';
    }

    protected $fillable = [
        'tensp',
        'don_gia',
        'ton_kho',
        'images',
        'giam_gia',
        'ngay_nhap',
        'mo_ta',
        'information',
        'ma_danhmuc',
        'id_dmphu',
        'promote',
        'dac_biet',
        'so_luot_xem',
        // Các trường mới
        'wholesale_price',
        'product_name',
        'manufacturer',
        'product_line',
        'sku',
        'imei_serial_number',
        'condition',
        'manufacture_date',
        'display',
        'cpu_chipset',
        'ram',
        'internal_storage',
        'operating_system',
        'battery',
        'rear_camera',
        'front_camera',
        'camera',
        'sim_support',
        'network',
        'wifi_bluetooth_nfc',
        'ports_connector',
        'connectivity_and_network',
        'dimensions_and_weight',
        'frame_and_back_materials',
        'colors',
        'water_dust_resistance_ip',
        'design_and_dimensions',
        'security',
        'charging_support',
        'special_features',
        'manufacturer_warranty',
        'store_warranty',
        'commercial_information',
        'inventory_and_sales',
        'units_received',
        'supplier',
    ];

    protected function casts(): array
    {
        return [
            'ngay_nhap' => 'datetime',
            'date_modified' => 'datetime',
            'don_gia' => 'decimal:2',
            'giam_gia' => 'integer',
            'promote' => 'boolean',
            'dac_biet' => 'boolean',
            'danhgia' => 'float',
        ];
    }

    /**
     * Relationships
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'ma_danhmuc', 'ma_danhmuc');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'id_dmphu');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'ma_sanpham', 'masanpham');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'idsanpham', 'masanpham');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'idsanpham', 'masanpham');
    }

    /**
     * Accessors
     */
    public function getImagesArrayAttribute(): array
    {
        return $this->images ? explode(',', $this->images) : [];
    }

    public function getThumbnailAttribute(): string
    {
        $images = $this->images_array;
        return $images[0] ?? 'default.jpg';
    }

    public function getDiscountedPriceAttribute(): float
    {
        return $this->don_gia * (1 - $this->giam_gia / 100);
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->discounted_price) . ' VND';
    }

    public function getOriginalFormattedPriceAttribute(): string
    {
        return number_format($this->don_gia) . ' VND';
    }

    public function getInStockAttribute(): bool
    {
        return $this->ton_kho > 0;
    }

    public function getOnSaleAttribute(): bool
    {
        return $this->giam_gia > 0;
    }

    /**
     * Scopes
     */
    public function scopeFeatured($query)
    {
        return $query->where('dac_biet', true);
    }

    public function scopeOnSale($query)
    {
        return $query->where('giam_gia', '>', 0);
    }

    public function scopeInStock($query)
    {
        return $query->where('ton_kho', '>', 0);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('ma_danhmuc', $categoryId);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('so_luot_xem', 'desc');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeSearchByName($query, $keyword)
    {
        return $query->where('tensp', 'like', '%' . $keyword . '%');
    }

    public function scopePriceRange($query, $minPrice = null, $maxPrice = null)
    {
        if ($minPrice) {
            $query->where('don_gia', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('don_gia', '<=', $maxPrice);
        }
        return $query;
    }

    /**
     * Methods
     */
    public function incrementViews(): void
    {
        $this->increment('so_luot_xem');
    }

    public function checkStock(int $quantity = 1): bool
    {
        return $this->ton_kho >= $quantity;
    }

    public function reduceStock(int $quantity): bool
    {
        if (!$this->checkStock($quantity)) {
            return false;
        }

        $this->decrement('ton_kho', $quantity);
        return true;
    }

    public function restoreStock(int $quantity): void
    {
        $this->increment('ton_kho', $quantity);
    }

    /**
     * Get related products from same category
     */
    public function getRelatedProducts(int $limit = 8)
    {
        return static::where('ma_danhmuc', $this->ma_danhmuc)
            ->where('masanpham', '!=', $this->masanpham)
            ->inStock()
            ->limit($limit)
            ->get();
    }

    /**
     * Get average rating
     */
    public function getAverageRatingAttribute(): float
    {
        return $this->reviews()->avg('rating_star') ?: 0;
    }

    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->count();
    }
}
