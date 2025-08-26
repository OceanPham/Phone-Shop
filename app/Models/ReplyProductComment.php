<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyProductComment extends Model
{
    use HasFactory;

    protected $table = 'tbl_reply_comments_product';
    protected $primaryKey = 'id';

    protected $fillable = [
        'comment_id',
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
    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id', 'id');
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

    public function scopeForComment($query, $commentId)
    {
        return $query->where('comment_id', $commentId);
    }
}
