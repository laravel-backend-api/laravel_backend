<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionOccurrence extends Model
{
    public function sessionTemplate() {
        return $this->belongsTo(SessionTemplate::class);
    }
    public function bookings() {
        return $this->hasMany(Booking::class);
    }
}
