<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    protected $fillable=[
        'name',
        'price',
        'discount',
        'category_id'
    ];

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
