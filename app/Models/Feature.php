<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['name', 'sort_order'];

    public function values()
    {
        return $this->hasMany(FeatureValue::class)->orderBy('sort_order');
    }
}
