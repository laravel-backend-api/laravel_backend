<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
     use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'role',
        'email',
        'password',
        'timezone',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * A user has one profile.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * The categories that a creator (user) has.
     *
     * This establishes the many-to-many relationship via the 'creator_categories' pivot table.
     */
    public function creatorCategories()
    {
        return $this->belongsToMany(Category::class, 'creator_categories');
    }

    /**
     * The subcategories that a creator (user) has.
     *
     * This establishes the many-to-many relationship via the 'creator_subcategories' pivot table.
     */
    public function creatorSubcategories()
    {
        return $this->belongsToMany(Subcategory::class, 'creator_subcategories');
    }

    /**
     * The sessions that a creator (user) has.
     *
     * This establishes the one-to-many relationship.
     */
    public function rooms()
    {
        return $this->hasMany(Room::class, 'creator_id');
    }

    /**
     * The occurrences that a user has booked.
     */
    public function bookedSessions()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    /**
     * The users that this user is following.
     *
     * The second argument specifies the pivot table name.
     * The third argument is the foreign key on the pivot table that refers to this model's ID.
     * The fourth argument is the foreign key on the pivot table that refers to the related model's ID.
     */
    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'creator_id');
    }

    /**
     * The users who are following this user.
     *
     * We use a new name for the relationship and swap the foreign keys.
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'creator_id', 'user_id');
    }
}
