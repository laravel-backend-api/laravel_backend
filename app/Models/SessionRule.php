<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_id',
        'weekday',
        'start_time',
        'end_time'
    ];
    public function template()
    {
        return $this->belongsTo(SessionTemplate::class, 'template_id');
    }
}
