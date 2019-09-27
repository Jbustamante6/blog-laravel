<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taggable extends Model
{
  
    protected $fillable = ['user_id', 'post_id', 'tag_id', 'taggable_type', 'created_at', 'updated_at', 'deleted_at'];

   
    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }
    
    public function tag()
    {
        return $this->belongsTo('App\Models\Tag');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
