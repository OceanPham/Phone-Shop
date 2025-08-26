<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'tbl_nguoidung';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tai_khoan',
        'mat_khau',
        'ho_ten',
        'email',
        'vai_tro',
        'diachi',
        'sodienthoai',
        'hinh_anh',
        'kich_hoat',
        'shipping_id',
        'default_payment',
        'congty',
        'about_me',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'mat_khau',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'mat_khau' => 'hashed',
            'kich_hoat' => 'boolean',
        ];
    }

    /**
     * Laravel authentication field mapping
     */
    public function getAuthPassword()
    {
        return $this->mat_khau;
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * Relationships
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'iduser');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'ma_nguoidung');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'iduser');
    }

    /**
     * Accessors & Mutators
     */
    public function getIsAdminAttribute(): bool
    {
        return in_array($this->vai_tro, [1, 2]);
    }

    public function getIsCustomerAttribute(): bool
    {
        return $this->vai_tro === 3;
    }

    public function getRoleTextAttribute(): string
    {
        $roles = [
            1 => 'Quản trị viên',
            2 => 'Moderator',
            3 => 'Khách hàng'
        ];
        return $roles[$this->vai_tro] ?? 'Không xác định';
    }

    /**
     * Scopes
     */
    public function scopeAdmins($query)
    {
        return $query->whereIn('vai_tro', [1, 2]);
    }

    public function scopeCustomers($query)
    {
        return $query->where('vai_tro', 3);
    }

    public function scopeActive($query)
    {
        return $query->where('kich_hoat', 1);
    }
}
