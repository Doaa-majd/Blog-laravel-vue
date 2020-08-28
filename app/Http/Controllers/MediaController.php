<?php

namespace App\Http\Controllers;
use App\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function allMedia(){
      $media = Media::orderBy('id','desc')->get();
      return response()->json([
          'media'=>$media
      ],200);
    }
}
