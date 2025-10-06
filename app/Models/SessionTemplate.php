<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionTemplate extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_id',
        'title',
        'description',
        'capacity',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function sessionRules()
    {
        return $this->hasMany(SessionRule::class, 'template_id');
    }
    public function sessionOccurrences()
    {
        return $this->hasMany(SessionOccurrence::class, 'template_id');
    }
}
