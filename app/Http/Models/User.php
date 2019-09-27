<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    
    protected $keyType = 'integer';

    protected $fillable = ['name', 'email', 'created_at', 'updated_at', 'deleted_at'];
    
    protected $hidden = ['password'];
    
    public function posts()
    {
        return $this->hasMany('App\Models\Post');
    }

    public function taggables()
    {
        return $this->hasMany('App\Models\Taggable');
    }
}
