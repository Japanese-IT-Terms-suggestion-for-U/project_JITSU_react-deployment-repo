<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Models\UserWord;
use App\Models\Word;
use Illuminate\Http\Request;

class UserWordController extends Controller
{
    /**
     * @Route("/favorite-word", name="favorite-words")
     * @return \Illuminate\View\View
     */
    public function getFavoriteWord(): View
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

    /**
     * @Route("/unfamiliar-word", name="unfamiliar-words")
     * @return \Illuminate\View\View
     */
    public function getUnfamiliarWord(): View
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

    /**
     * @Route("/next-favorite-word", name="next-favorite-word")
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNextFavoriteWord(Request $request): JsonResponse
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

    /**
     * @Route("/next-unfamiliar-word", name="next-unfamiliar-word")
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNextUnfamiliarWord(Request $request): JsonResponse
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

    /**
     * @Route("/user-words/{word}", name="user-words.update")
     * @param Request $request, $wordNumber
     * @return \Illuminate\Http\JsonResponse
     */
    public function addWordPad(Request $request, $wordNumber): JsonResponse
    {
        $status = $request->input('status');

        $word = Word::where('id', $wordNumber)->first();

        if (!$word) {
            $newWord = new Word();
            $newWord->id = $wordNumber;
            $newWord->save();

            $word = $newWord;
        }

        $userWord = UserWord::firstOrNew(['user_id' => auth()->user()->id, 'word_number' => $word->id], ['is_favorite' => false, 'is_memorized' => false]);

        if ($status === 'favorite') {
            $userWord->is_favorite = true;
        } elseif ($status === 'memorized') {
            $userWord->is_memorized = true;
        }

        $userWord->save();

        return response()->json($word);
    }

    /**
     * @Route("/word-status/{wordId}", name="word-status")
     * @param $wordId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWordStatus($wordId): JsonResponse
    {
        $wordStatus = UserWord::where('user_id', auth()->user()->id)
            ->where('word_number', $wordId)
            ->select('is_favorite', 'is_memorized')
            ->first();

        if ($wordStatus === null) {
            return response()->json(['error' => '단어 상태 정보를 찾을 수 없습니다.']);
        }

        return response()->json($wordStatus);
    }
}