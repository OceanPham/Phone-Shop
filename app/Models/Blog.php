<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'tbl_blog';
    protected $primaryKey = 'blog_id';

    protected $fillable = [
        'blog_title',
        'noi_dung',
        'images',
        'create_time',
        'blogcate_id',
        'tags',
        'duyet',
    ];

    protected function casts(): array
    {
        return [
            'create_time' => 'datetime',
            'duyet' => 'boolean',
        ];
    }

    /**
     * Relationships
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blogcate_id');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'id_blog', 'blog_id');
    }

    /**
     * Accessors
     */
    public function getImageUrlAttribute(): string
    {
        return $this->images ? asset('storage/uploads/' . $this->images) : asset('images/default-blog.jpg');
    }

    public function getExcerptAttribute(): string
    {
        return Str::limit(strip_tags($this->noi_dung), 200);
    }

    public function getTagsArrayAttribute(): array
    {
        return $this->tags ? explode(',', $this->tags) : [];
    }

    /**
     * Scopes
     */
    public function scopePublished($query)
    {
        return $query->where('duyet', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('create_time', 'desc');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('blogcate_id', $categoryId);
    }

    public function scopeByTag($query, $tag)
    {
        return $query->where('tags', 'like', '%' . $tag . '%');
    }
}
