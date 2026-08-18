<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'discount',
        'discount_ends_at',
        'description',
        'slug',
        'brand_id',
        'user_id',
        'stock',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'discount_ends_at' => 'datetime',
        ];
    }

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

    public function scopeActiveDiscount($query)
    {
        return $query->where('discount', '>', 0)
            ->where(function ($q) {
                $q->whereNull('discount_ends_at')
                    ->orWhere('discount_ends_at', '>', now());
            });
    }

    public function getDiscountActiveAttribute(): bool
    {
        return $this->discount > 0
            && ($this->discount_ends_at === null || $this->discount_ends_at->isFuture());
    }

    public function getDiscountedPriceAttribute()
    {
        return $this->discount_active
            ? $this->price - ($this->price * $this->discount / 100)
            : $this->price;
    }

    public function getFormattedDiscountedPriceAttribute()
    {
        return number_format($this->discounted_price).' تومان';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(SportImage::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product')
            ->withTimestamps();
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function featureValues()
    {
        return $this->belongsToMany(FeatureValue::class, 'product_feature_value')
            ->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }
}
