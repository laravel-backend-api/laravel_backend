<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionTemplate extends Model
{
    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function sessionRule() {
        return $this->hasOne(SessionRule::class);
    }

    public function sessionOccurences() {
        return $this->hasMany(SessionOccurrence::class);
    }

    

}
