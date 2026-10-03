<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    protected $fillable = [
        'phone', 'code', 'purpose', 'name', 'email', 'password',
        'expires_at', 'attempts', 'verified_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function isValid(): bool
    {
        return $this->verified_at === null
            && $this->attempts < 5
            && $this->expires_at->isFuture();
    }
}
