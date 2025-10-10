<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadgeAward extends Model
{
    use HasFactory;
    protected $fillable = ['badge_id', 'user_id', 'awarded_at'];

    protected $casts = [
        'awarded_at' => 'datetime',
    ];

    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


