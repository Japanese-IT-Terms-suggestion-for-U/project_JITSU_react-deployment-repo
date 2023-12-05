<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    public function show()
    {
        $comment = new Comment();

        $post = Post::where('post_id', 1)->firstOrFail();
        $comments = $comment->where('post_id', 1)->get();

        return view('board', compact('post', 'comments'));
    }
}
