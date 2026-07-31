<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureValue extends Model
{
    protected $fillable = ['feature_id', 'value', 'sort_order'];

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
