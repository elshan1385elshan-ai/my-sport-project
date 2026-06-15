<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SportImage extends Model {
    protected $fillable = ['sport_id', 'image_path'];

    public function sport() {
        return $this->belongsTo(Sport::class);
    }
}