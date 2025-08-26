<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $table = 'tbl_blog_cate';
    protected $primaryKey = 'blogcate_id';

    protected $fillable = [
        'catename',
        'intro_cate',
        'images',
        'date_create',
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
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'blogcate_id', 'blogcate_id');
    }

    /**
     * Accessors
     */
    public function getImageUrlAttribute(): string
    {
        return $this->images ? asset('storage/uploads/' . $this->images) : asset('images/default-category.jpg');
    }

    public function getBlogCountAttribute(): int
    {
        return $this->blogs()->count();
    }

    public function getPublishedBlogCountAttribute(): int
    {
        return $this->blogs()->published()->count();
    }

    /**
     * Scopes
     */
    public function scopeWithBlogs($query)
    {
        return $query->withCount('blogs');
    }

    public function scopeWithPublishedBlogs($query)
    {
        return $query->withCount(['blogs' => function ($query) {
            $query->published();
        }]);
    }
}
