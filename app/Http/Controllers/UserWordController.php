<?php

namespace App\Http\Controllers;

use App\Models\UserWord;
use App\Models\Word;
use Illuminate\Http\Request;

class UserWordController extends Controller
{
    public function index()
    {
        $word = Word::inRandomOrder()->first();
        if (!$word) {
            $word = new Word();
            $word->word_number = 0;
        }
        return view('dashboard', ['word' => $word]);
    }

    public function update(Request $request, $wordNumber)
    {
        $status = $request->input('status');

        $word = Word::where('word_number', $wordNumber)->first();

        if (!$word) {
            $newWord = new Word();
            $newWord->word_number = $wordNumber;
            $newWord->save();

            $word = $newWord;
        }

        $userWord = UserWord::firstOrNew(['user_id' => auth()->user()->id, 'word_number' => $word->word_number], ['is_favorite' => false, 'is_memorized' => false]);

        if ($status === 'favorite') {
            $userWord->is_favorite = true;
        } elseif ($status === 'memorized') {
            $userWord->is_memorized = true;
        }

        $userWord->save();

        return response()->json($word);
    }
}
