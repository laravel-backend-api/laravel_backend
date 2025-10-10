<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaderboard extends Model
{
    use HasFactory;
    protected $fillable = ['period', 'role', 'rank_json', 'computed_at'];

    protected $casts = [
        'rank_json' => 'array',
        'computed_at' => 'datetime',
    ];
}


