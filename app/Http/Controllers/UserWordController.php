<?php

namespace App\Http\Controllers;

use App\Models\UserWord;
use App\Models\Word;
use Illuminate\Http\Request;

class UserWordController extends Controller
{
    public function getFavoriteWord()
    {
        $word = UserWord::where('user_id', auth()->user()->id)
            ->where('is_favorite', true)
            ->with('word')
            ->first();

        if ($word === null) {
            return view('profile.partials.favorite-word-form', ['error' => '즐겨찾기로 표시된 단어가 없습니다.']);
        }

        return response()->json($word);
    }

    public function getUnfamiliarWord()
    {
        $word = UserWord::where('user_id', auth()->user()->id)
            ->where('is_memorized', true)
            ->with('word')
            ->first();

        if ($word === null) {
            return view('profile.partials.unfamiliar-word-form', ['error' => '모르는 단어로 표시된 단어가 없습니다.']);
        }

        return response()->json($word);
    }

    public function getNextFavoriteWord(Request $request)
    {
        $currentWordNumber = $request->input('word_number');
        $nextFavoriteWord = UserWord::where('user_id', auth()->user()->id)
            ->where('is_favorite', true)
            ->where('word_number', '>', $currentWordNumber)
            ->with('word')
            ->orderBy('word_number')
            ->first();

        if (!$nextFavoriteWord) {
            $nextFavoriteWord = UserWord::where('user_id', auth()->user()->id)
                ->where('is_favorite', true)
                ->with('word')
                ->orderBy('word_number')
                ->first();
        }

        return response()->json($nextFavoriteWord ? $nextFavoriteWord->word : null);
    }

    public function getNextUnfamiliarWord(Request $request)
    {
        $currentWordNumber = $request->input('word_number');
        $nextUnfamiliarWord = UserWord::where('user_id', auth()->user()->id)
            ->where('is_memorized', true)
            ->where('word_number', '>', $currentWordNumber)
            ->with('word')
            ->orderBy('word_number')
            ->first();

        if (!$nextUnfamiliarWord) {
            $nextUnfamiliarWord = UserWord::where('user_id', auth()->user()->id)
                ->where('is_memorized', true)
                ->with('word')
                ->orderBy('word_number')
                ->first();
        }

        return response()->json($nextUnfamiliarWord ? $nextUnfamiliarWord->word : null);
    }

    public function addWordPad(Request $request, $wordNumber)
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