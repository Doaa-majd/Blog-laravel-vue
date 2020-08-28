<?php

namespace App;
//namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;


class Post extends Model implements HasMedia
{
  use HasMediaTrait;

  protected $fillable = ['title', 'description'];

    public  function user(){
     return $this->belongsTo(User::class);
    }

    public function comments(){
       return $this->hasMany(Comment::class);
    }

    public function getThreadedComments(){
        return $this->comments()->with('user')->get()->threaded();
    }

    public function addComment($attributes)
    {
        $comment = (new Comment())->forceFill($attributes);
        $comment->user_id = auth()->id();
        return $this->comments()->save($comment);
    }

     public  function category(){
         return $this->belongsTo(Category::class,'cat_id');
     }

     public function tag()
     {
         return $this->belongsToMany(Tag::class, 'post_tags');
     }
     public function image()
     {
         return $this->morphOne('App\Media', 'model', 'model_type');
     }
}
