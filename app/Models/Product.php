<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'brand',
        'description',
        'price',
        'old_price',
        'image',
        'images',
        'stock',
        'is_active',
        'category',
        'sport_type',
        'player_name',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'images' => 'array',
        'is_active' => 'boolean',
    ];

    // اگر از Slug استفاده می‌کنی (توصیه می‌شود)
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = \Str::slug($product->name);
            }
        });
    }

    // Scope برای محصولات فعال
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessor برای نمایش قیمت با کاما
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price) . ' تومان';
    }
}