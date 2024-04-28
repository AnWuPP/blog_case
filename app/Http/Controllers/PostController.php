<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('post.show', ['post' => $post]);
    }

    public function comment(Request $request, $id)
    {
        $request->validate([
            'text' => 'required',
        ]);
        $post = Post::findOrFail($id);
        $comment = Comment::create([
            'text' => $request->text,
            'post_id' => $post->id,
            'user_id' => Auth::id(),
        ]);
        $comment->save();
        return redirect()->route('post.show', $id);
    }
}
