<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionOccurrence extends Model
{
    use HasFactory;
    protected $fillable = [
        'template_id',
        'start_at',
        'end_at',
        'capacity',
        'status',
        'drive_link',
        'stats_cached_json'
    ];
    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];
    public function template()
    {
        return $this->belongsTo(SessionTemplate::class);
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'occurrence_id');
    }
}
