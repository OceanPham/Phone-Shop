<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'tbl_danhmuc_phu';

    protected $fillable = [
        'iddm',
        'ten_danhmucphu',
        'mo_ta',
    ];

    /**
     * Relationships
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'iddm', 'ma_danhmuc');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'id_dmphu');
    }

    /**
     * Accessors
     */
    public function getProductCountAttribute(): int
    {
        return $this->products()->count();
    }
}
