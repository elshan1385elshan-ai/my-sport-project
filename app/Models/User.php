<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_seller',
        'shop_name',
        'shop_description',
        'shop_slug',
        'shop_logo',
        'shop_social',
        'seller_status',
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
        ];
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
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