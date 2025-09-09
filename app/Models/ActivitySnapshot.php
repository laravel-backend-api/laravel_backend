<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivitySnapshot extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activity_snapshots';

    /**
     * The `morphTo` method is the core of a polymorphic relationship.
     * It allows a single model (ActivitySnapshot) to belong to more than one
     * other model (e.g., User, Room) on a single relationship.
     *
     * The first argument is the name of the relationship.
     * By convention, Laravel looks for `{name}_type` and `{name}_id` columns.
     * In this case, it will look for `entity_type` and `entity_id`.
     */
    public function entity(){
        return $this->morphTo('entity');
    }
}
