<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Word;
use App\Models\Tag;

class WordController extends Controller
{
    public function store(Request $request)
    {
        $word = new Word([
            'japanese' => $request->japanese,
            'korean' => $request->korean,
            'korean_definition' => $request->korean_definition,
            'tag' => $request->tag,
        ]);

        $word->save();

        $tagExists = Tag::where('tag_name', $request->tag)->exists();

        if (!$tagExists) {
            $tag = new Tag(['tag_name' => $request->tag]);
            $tag->save();
        }

        return redirect('dashboard');
    }

    public function index()
    {
        $word = Word::first();
        return view('dashboard', ['word' => $word]);
    }

    public function random()
    {
        $word = Word::inRandomOrder()->first();
        return response()->json($word);
    }
}
