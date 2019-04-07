<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    public function entitiesLoader()
    {
        return $this->hasMany(EntityLoader::class, 'entity_id');
    }
}
