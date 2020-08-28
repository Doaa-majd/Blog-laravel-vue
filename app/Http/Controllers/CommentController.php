<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class CommentController extends Controller
{
    public function addComment(Request $request)
    {

            $post = Post::where('id', '=', $request->get('post_id'))->first();
            $post->addComment([
                'content' => $request->get('replyContent'),
                'parent_id' => $request->get('parent_id', null)
                ]);

            return response()->json([
                'comments'=> $post->getThreadedComments(),
            ],200);

    }
}
