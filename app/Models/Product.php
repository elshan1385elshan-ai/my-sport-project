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
        'description',
        'slug',
        'brand_id',
        'user_id',
        'stock',
        'is_active',
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
    // public function scopeActive($query)
    // {
    //     return $query->where('is_active', true);
    // }

    public function getDiscountedPriceAttribute()
    {
        return $this->discount > 0
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
