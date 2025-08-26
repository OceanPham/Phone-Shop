<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    protected $table = 'tbl_slider';
    protected $primaryKey = 'slider_id';

    protected $fillable = [
        'slider_name',
        'slider_image',
        'slider_url',
        'date_create',
        'slider_status',
    ];

    protected function casts(): array
    {
        return [
            'date_create' => 'datetime',
            'slider_status' => 'boolean',
        ];
    }

    /**
     * Accessors
     */
    public function getImageUrlAttribute(): string
    {
        return $this->slider_image ? asset('storage/uploads/' . $this->slider_image) : asset('images/default-slider.jpg');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('slider_status', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('date_create', 'desc');
    }
}
