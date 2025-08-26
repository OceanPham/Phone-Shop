<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'tbl_danhgiasp';
    protected $primaryKey = 'id_review';

    protected $fillable = [
        'iduser',
        'idsanpham',
        'images_review',
        'noidung',
        'rating_star',
        'date_create',
        'iddonhang',
        'trangthai_review',
    ];

    protected function casts(): array
    {
        return [
            'rating_star' => 'decimal:1',
            'date_create' => 'datetime',
            'trangthai_review' => 'boolean',
        ];
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'iduser');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'idsanpham', 'masanpham');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'iddonhang');
    }

    public function replies()
    {
        return $this->hasMany(ReplyReview::class, 'review_id', 'id_review');
    }

    /**
     * Accessors
     */
    public function getImagesArrayAttribute(): array
    {
        return $this->images_review ? explode(',', $this->images_review) : [];
    }

    public function getStarIconsAttribute(): string
    {
        $rating = (int) $this->rating_star;
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '<i class="fas fa-star text-yellow-400"></i>';
            } else {
                $stars .= '<i class="far fa-star text-gray-300"></i>';
            }
        }
        return $stars;
    }

    /**
     * Scopes
     */
    public function scopePublished($query)
    {
        return $query->where('trangthai_review', true);
    }

    public function scopeByRating($query, $rating)
    {
        return $query->where('rating_star', $rating);
    }
}
