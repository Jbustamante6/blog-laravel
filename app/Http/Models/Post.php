<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
 
    protected $keyType = 'integer';


    protected $fillable = ['user_id', 'title', 'created_at', 'updated_at', 'deleted_at'];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function taggables()
    {
        return $this->hasMany('App\Models\Taggable');
    }
}
