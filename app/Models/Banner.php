<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'tbl_banner';

    protected $fillable = [
        'name',
        'idsp',
        'images',
        'noi_dung',
        'date_create',
        'info',
    ];

    protected function casts(): array
    {
        return [
            'date_create' => 'datetime',
        ];
    }

    /**
     * Relationships
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'idsp', 'masanpham');
    }

    /**
     * Accessors
     */
    public function getImageUrlAttribute(): string
    {
        return $this->images ? asset('storage/uploads/' . $this->images) : asset('images/default-banner.jpg');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->whereNotNull('images');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('date_create', 'desc');
    }
}
