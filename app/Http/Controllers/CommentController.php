<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * @Route("/post/comments", name="post.comments")
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $comment = Comment::create([
            'content' => $request->content,
            'post_id' => 1,
            'user_id' => $request->user()->id
        ]);

        return back()->with('success', 'コメントが投稿されました！');
    }

    /**
     * @Route("/post/comments/{comment}", name="post.comments.update")
     * @param Request $request, Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Comment $comment): RedirectResponse
    {
        $this->authorize('update', $comment);

        $comment->content = $request->content;
        $comment->save();

        return back()->with('success', 'コメントが変更されました！');
    }

    /**
     * @Route("/post/comments/{comment}", name="post.comments.destroy")
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'コメントが削除されました！');
    }
}
