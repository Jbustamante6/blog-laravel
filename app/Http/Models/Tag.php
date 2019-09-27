<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Tag extends Model
{
 
    protected $keyType = 'integer';

    protected $fillable = ['name', 'created_at', 'updated_at', 'deleted_at'];

    public function taggables()
    {
        return $this->hasMany('App\Models\Taggable');
    }
}
