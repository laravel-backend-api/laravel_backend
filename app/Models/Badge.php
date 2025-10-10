<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'role_target', 'threshold_points', 'icon', 'order'];

    public function awards()
    {
        return $this->hasMany(BadgeAward::class);
    }
}


