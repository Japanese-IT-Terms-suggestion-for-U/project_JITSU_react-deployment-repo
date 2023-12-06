<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    /**
     * @Route("/board", name="board")
     * @return \Illuminate\View\View
     */
    public function show(): View
    {
        $comment = new Comment();

        $post = Post::where('post_id', 1)->firstOrFail();
        $comments = $comment->where('post_id', 1)->get();

        return view('board', compact('post', 'comments'));
    }
}
