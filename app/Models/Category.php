<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'image',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product')
            ->withTimestamps();
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('childrenRecursive');
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'category_feature');
    }
}
