<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'tbl_comment';
    protected $primaryKey = 'ma_binhluan';

    protected $fillable = [
        'noi_dung',
        'ma_sanpham',
        'ma_nguoidung',
        'duyet',
        'ngay_binhluan',
    ];

    protected function casts(): array
    {
        return [
            'duyet' => 'boolean',
            'ngay_binhluan' => 'datetime',
        ];
    }

    /**
     * Relationships
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'ma_sanpham', 'masanpham');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'ma_nguoidung');
    }

    public function replies()
    {
        return $this->hasMany(ReplyProductComment::class, 'comment_id', 'ma_binhluan');
    }

    /**
     * Scopes
     */
    public function scopeApproved($query)
    {
        return $query->where('duyet', true);
    }

    public function scopePending($query)
    {
        return $query->where('duyet', false);
    }
}
