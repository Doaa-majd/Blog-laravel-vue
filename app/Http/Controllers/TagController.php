<?php

namespace App\Http\Controllers;
use App\Tag;

use Illuminate\Http\Request;

class TagController extends Controller
{
  public function test(){
      $tt = Tag::with('post')->get();
      foreach ($tt as $tagt) {

      $newt[]= $tagt->post;
    }
    return $newt;

  }
    public function allTags(){
    $tag = Tag::with('post')->orderBy('id', 'DSC')->paginate(5);
      return response()->json([
          'tags'=>$tag
      ],200);
    }
    public function getPostsByTag($tagid){
      $tag = Tag::find($tagid);
      $postsbytag = $tag->post()->get();
      return response()->json([
          'postsbytag'=>$postsbytag
      ],200);
    }

    public function tagsPost(){
     $tag = Tag::latest()->take(10)->get()->pluck('name');
     $tags = array();
     foreach ($tag as $key => $tagvalue) {
       $tags[] = (object)['text' => $tagvalue];
     }
     return $tags;

    }

    public function saveTag(Request $request){
      $this->validate($request,[
          'tagname'=>'required|min:2|max:30'
      ]);
      $tag = new Tag();
      $tag->name = $request->tagname;
      $tag->slug = $request->slug;
      $tag->description = $request->description;
      $tag->save();
    }

    public function update_tag(Request $request,$id){
      $tag = Tag::find($id);
      $this->validate($request,[
          'name'=>'required|min:2|max:30'
      ]);
      $tag->name = $request->name;
      $tag->slug = $request->slug;
      $tag->description = $request->description;
      $tag->save();
    }

    public function delete_tag($id){
      $tag = Tag::find($id);
      $tag->delete();
    }

}
