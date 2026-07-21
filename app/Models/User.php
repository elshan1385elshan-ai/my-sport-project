<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_seller',
        'shop_name',
        'shop_description',
        'shop_slug',
        'shop_logo',
        'shop_social',
        'seller_status',
        'seller_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_seller' => 'boolean',
            'shop_social' => 'array',
            'seller_verified_at' => 'datetime',
        ];
    }

    public function isSeller(): bool
    {
        return $this->is_seller;
    }

    public function isApprovedSeller(): bool
    {
        return $this->is_seller && $this->seller_status === 'approved';
    }

    public function scopeSellers($query)
    {
        return $query->where('is_seller', true);
    }

    public function scopeApprovedSellers($query)
    {
        return $query->where('is_seller', true)->where('seller_status', 'approved');
    }
}
