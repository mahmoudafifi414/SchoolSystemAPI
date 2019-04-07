<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntityLoader extends Model
{
    protected $table = 'entities_loaders';
    public function entities()
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }
}
