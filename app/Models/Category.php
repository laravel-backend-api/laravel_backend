<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
     public function subcategories() {
        return $this->hasmany(Subcategory::class);
    }
    public function users() {
        return $this->belongsToMany(User::class, 'creator_categories');
    }
}
