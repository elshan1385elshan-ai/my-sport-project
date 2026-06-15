<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

      protected $fillable=[
        'name',
        'price',
        'discount',
        'category_id'
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
  

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function images(){
        return $this->hasMany(SportImage::class);
    }
    public function category(){
        return $this->belongsToMany(Category::class);
    }
}