<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use App\Post;

use App\Comment;
use App\User;
use App\Notifications\NotifyPostOwner;
class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|min:4'
        ]);
        Comment::create([
            'user_id' => Auth::user()->id,
            'comment' => $request->comment,
            'post_id' => $request->post_id
        ]);
      
        $post=Post::find($request->post_id);
        $user=User::find($post->user_id)->notify(new NotifyPostOwner($post));

        Session::flash('status', 'Comment was successfully created');
        return redirect()->back();
    }
}
