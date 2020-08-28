<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Auth;
use Image;

class PostController extends Controller
{
  public function for_test(){
    $post =  Post::find(29);
    $post['comments'] = $post->getThreadedComments();

  return response()->json([
      'post'=>$post
  ],200);

}
public function img_test(){
  $post =  Post::find(18);
$tt=  $post->getMedia('img');
 //$imgpath = $tt[0]->delete();

return response()->json([
    'img'=>'successfully'
],200);
/*
$posts = Post::with(array('image' => function($query)
{ $query->where('collection_name','=', 'img');
}))->with('user')->orderBy('id','desc')->get();

return response()->json([
    'posts'=>$posts
],200);
$post =  Post::find(20);
 return storage_path()."/app/public/".$post->image()->get()[0]->file_name;
*/
}
    public function all_post(){
       $posts = Post::with('user','category','image')->orderBy('id','desc')->get();
       return response()->json([
           'posts'=>$posts
       ],200);
    }
    public function save_post(Request $request){
       $this->validate($request,[
           'title'=>'required|min:2|max:50',
           'description'=>'required|min:2|max:1000'
       ]);

       $strpos = strpos($request->photo,';');
       $sub = substr($request->photo,0,$strpos);
       $ex = explode('/',$sub)[1];
       $name = time().".".$ex;
    /*   $img = Image::make($request->photo)->resize(200, 200);
       $upload_path = public_path()."/uploadimage/";
       $img->save($upload_path.$name);*/

       $post = new Post();
       $post->title = $request->title;
       $post->description = $request->description;
       $post->cat_id = $request->cat_id;
       $post->user_id = Auth::user()->id;
       //$post->photo = $name;
       $post->slug = $request->slug;
       $post->save();
       //////////////////for image Insert
       Post::find($post->id)->addMediaFromBase64($request->photo)->usingFileName($name)->toMediaCollection('posts-img');
       /////////////////for tags insert
       $id = array();
       foreach($request->tags as $ptag){
         $id[] = Tag::firstOrCreate(['name'=>$ptag['text']])->id;
       }
       $post->tag()->attach($id);
   }

   public function delete_post($id){
       $post = Post::find($id);

       $post->delete();
   }

   public function edit_post($id){
       $post = Post::find($id);
       $post_photo = $post->image()->get()[0]->file_name ;

       $tags = Post::find($id)->tag()->get()->pluck('name');
       $posttags = array();
       foreach ($tags as $tagv) {
         $posttags[]= (object)['text' => $tagv];
       }

       return response()->json([
           'post'=>$post,
           'tags' => $posttags,
           'photo'=>$post_photo,
       ],200);
   }

   public function update_post(Request $request, $id){
       $post = Post::find($id);
       $this->validate($request,[
           'title'=>'required|min:2|max:50',
           'description'=>'required|min:2|max:1000'
       ]);
      $post_photo = $post->image()->get()[0]->file_name ;

       if($request->photo != $post_photo){
           $strpos = strpos($request->photo,';');
           $sub = substr($request->photo,0,$strpos);
           $ex = explode('/',$sub)[1];
           $name = time().".".$ex;
           $post->image()->delete();
           $post->addMediaFromBase64($request->photo)->usingFileName($name)->toMediaCollection('posts-img');
       }
       $post->title = $request->title;
       $post->description = $request->description;
       $post->cat_id = $request->cat_id;
       $post->slug = $request->slug;
       $post->user_id = Auth::user()->id;
       $post->save();
       ///////////for tags
       $tag_array = $this->updateTags( $id, $request->tags);
       $post->tag()->sync($tag_array);

   }

   public function testTags(){
    /* $post = new Post();
     $post->title = 'uptest';
     $post->description = 'test-testtest-testtest-testtest-test';
     $post->cat_id = 16;
     $post->user_id = Auth::user()->id;
     $post->photo = 'https://lorempixel.com/640/480/?96672';
     $post->slug = 'uptest';
     $post->save();
*/
  //   $tag = new Tag();
//$id[] = $tag->create(['name'=>'test','slug'=>'test'])->id;
  return Tag::firstOrCreate(['name'=>'python'])->id;
  //   $post->tag()->attach($id);
   }

   public function updateTags($post_id,$tags_array){
     $tagnames = array();
     foreach($tags_array as $tagname){
       $tagnames[] = $tagname['text'];
     }

    $tags = Post::find($post_id)->tag()->get();
    $oldtag = array();
     foreach ($tags as $tagv) {
       $oldtag[$tagv->id]= $tagv->name ;
     }
     //print_r($oldtag);//array from db --taqs to this post
     $deltag = array_diff($oldtag,$tagnames);//to delete the non exit tags
     $addtag = array_diff($tagnames,$oldtag);//to add new one

     $tag = new Tag();

      if(!empty($deltag)){
        foreach ($deltag as $key => $value) {
              unset($oldtag[$key]);
              Tag::find($key)->delete();
        }
      }
      $id = array();
      if(!empty($addtag)){
        foreach ($addtag as $tvalue) {
        $id[]= Tag::firstOrCreate(['name'=>$tvalue])->id;
        }
      }
     return array_merge(array_keys($oldtag),$id);
   }



}
