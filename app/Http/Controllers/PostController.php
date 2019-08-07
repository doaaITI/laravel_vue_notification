<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
 
use Auth;
use Session;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:6',
            'content' => 'required|min:20'
        ]);
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::user()->id
        ]);
        Session::flash('status', 'A new Post was successfully created');
        return redirect()->back();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('post.show')->withPost($post);
    }
}
