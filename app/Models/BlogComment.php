<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;

    protected $table = 'tbl_blog_comment';
    protected $primaryKey = 'blogcomment_id';

    protected $fillable = [
        'id_blog',
        'noi_dung',
        'ten_user',
        'email_user',
        'ngay_comment',
        'duyet',
    ];

    protected function casts(): array
    {
        return [
            'ngay_comment' => 'datetime',
            'duyet' => 'boolean',
        ];
    }

    /**
     * Relationships
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class, 'id_blog', 'blog_id');
    }

    public function replies()
    {
        return $this->hasMany(ReplyBlogComment::class, 'comment_id', 'blogcomment_id');
    }

    /**
     * Scopes
     */
    public function scopeApproved($query)
    {
        return $query->where('duyet', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('ngay_comment', 'desc');
    }

    public function scopeForBlog($query, $blogId)
    {
        return $query->where('id_blog', $blogId);
    }
}
