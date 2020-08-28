<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name','slug'];

    public function post()
    {
        return $this->belongsToMany(Post::class, 'post_tags');
    }

    public function relatedPosts()
    {
      return Tag::whereHas('post', function($q){
        $postIds = $this->post()->pluck('post_id')->all();
        $q->whereIn('post_id',$postIds);
      })->get();
    }
}
