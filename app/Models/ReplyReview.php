<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyReview extends Model
{
    use HasFactory;

    protected $table = 'tbl_reply_reviews';
    protected $primaryKey = 'id';

    protected $fillable = [
        'review_id',
        'reply_content',
        'reply_author',
        'reply_email',
        'reply_date',
        'approved',
    ];

    protected function casts(): array
    {
        return [
            'reply_date' => 'datetime',
            'approved' => 'boolean',
        ];
    }

    /**
     * Relationships
     */
    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id', 'id');
    }

    /**
     * Scopes
     */
    public function scopeApproved($query)
    {
        return $query->where('approved', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('reply_date', 'desc');
    }

    public function scopeForReview($query, $reviewId)
    {
        return $query->where('review_id', $reviewId);
    }
}
