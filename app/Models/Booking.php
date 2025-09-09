<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function sessionOccurrence() {
        return $this->belongsTo(SessionOccurrence::class);
    }

    public function user () {
        return $this->belongsTo(User::class);
    }
}
