<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use JWTAuth;

class User extends Model
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

    public static function resolveId()
    {   
        $user = JWTAuth::parseToken()->authenticate();
        return $user->id;
    }
}
