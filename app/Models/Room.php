<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function users() {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function sessionTemplates() {
        return $this->hasMany(SessionTemplate::class);
    }

}
