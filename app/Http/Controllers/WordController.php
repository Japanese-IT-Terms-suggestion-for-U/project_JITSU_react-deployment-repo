<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Word;
use App\Models\Tag;
use App\Models\UserTag;

class WordController extends Controller
{
    /**
     * @Route("/dashboard", name="dashboard")
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $userTagIds = UserTag::where('user_id', Auth::id())->pluck('tag_id');

        $word = Word::with('tag')->whereIn('tag_id', $userTagIds)->inRandomOrder()->first();

        return view('dashboard', ['word' => $word]);
    }

    /**
     * @Route("/words", name="words")
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $word = new Word([
            'japanese' => $request->japanese,
            'korean' => $request->korean,
            'korean_definition' => $request->korean_definition,
            'tag_id' => $request->tag_id,
        ]);

        $word->save();

        $tagExists = Tag::where('tag_name', $request->tag)->exists();

        if (!$tagExists) {
            $tag = new Tag(['tag_name' => $request->tag]);
            $tag->save();
        }

        return redirect('dashboard');
    }

    /**
     * @Route("/random-word", name="random-word")
     * @return \Illuminate\Http\JsonResponse
     */
    public function random(): JsonResponse
    {
        $userTagIds = UserTag::where('user_id', Auth::id())->pluck('tag_id');

        $word = Word::with('tag')->whereIn('tag_id', $userTagIds)->inRandomOrder()->first();

        return response()->json($word);
    }
}
