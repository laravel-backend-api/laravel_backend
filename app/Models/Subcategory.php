<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    public function category() {
        return $this->belongsTo(Category::class);
    }
    /**
     * A subcategory can be associated with many users (creators).
     * This is the inverse of the many-to-many relationship defined in the User model.
     */
    public function users(){
        // The second argument is the pivot table name.
        return $this->belongsToMany(User::class, 'creator_subcategories');
    }
}
