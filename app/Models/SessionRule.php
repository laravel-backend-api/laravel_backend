<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionRule extends Model
{
     public function sessionTemplate() {
        return $this->belongsTo(SessionTemplate::class);
    }

}
