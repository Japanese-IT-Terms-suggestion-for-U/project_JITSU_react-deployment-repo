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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFavoriteWord(): JsonResponse
    {
        try {
            $word = UserWord::where('user_id', auth()->user()->id)
                ->where('is_favorite', true)
                ->with('word', 'word.tag')
                ->first();

            if (!$word) {
                return response()->json(['error' => '즐겨찾기 단어로 표시된 단어가 없습니다.'], 404);
            }

            return response()->json($word);
        } catch (\Exception $e) {
            // Log error
            return response()->json(['error' => '데이터 가져오기 중 오류가 발생했습니다.'], 500);
        }
    }

    /**
     * @Route("/unfamiliar-word", name="unfamiliar-words")
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnfamiliarWord(): JsonResponse
    {
        try {
            $word = UserWord::where('user_id', auth()->user()->id)
                ->where('is_memorized', true)
                ->with('word', 'word.tag')
                ->first();

            if (!$word) {
                return response()->json(['error' => '모르는 단어로 표시된 단어가 없습니다.']);
            }

            return response()->json($word);
        } catch (\Exception $e) {
            // Log error
            return response()->json(['error' => '데이터 가져오기 중 오류가 발생했습니다.'], 500);
        }
    }

    /**
     * @Route("/next-favorite-word", name="next-favorite-word")
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNextFavoriteWord(Request $request): JsonResponse
    {
        $currentWordNumber = $request->input('wordId');

        if (!is_numeric($currentWordNumber)) {
            return response()->json(['error' => '유효하지 않은 단어 번호입니다.']);
        }

        $nextFavoriteWord = UserWord::where('user_id', auth()->user()->id)
            ->where('is_favorite', true)
            ->where('word_number', '>', $currentWordNumber)
            ->with(['word', 'word.tag'])
            ->orderBy('word_number')
            ->first();

        if (!$nextFavoriteWord) {
            $nextFavoriteWord = UserWord::where('user_id', auth()->user()->id)
                ->where('is_favorite', true)
                ->with(['word', 'word.tag'])
                ->orderBy('word_number')
                ->first();
        }

        return response()->json($nextFavoriteWord->word);
    }

    /**
     * @Route("/next-unfamiliar-word", name="next-unfamiliar-word")
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNextUnfamiliarWord(Request $request): JsonResponse
    {
        $currentWordNumber = $request->input('wordId');
        $nextUnfamiliarWord = UserWord::where('user_id', auth()->user()->id)
            ->where('is_memorized', true)
            ->where('word_number', '>', $currentWordNumber)
            ->with(['word', 'word.tag'])
            ->orderBy('word_number')
            ->first();

        if (!$nextUnfamiliarWord) {
            $nextUnfamiliarWord = UserWord::where('user_id', auth()->user()->id)
                ->where('is_memorized', true)
                ->with(['word', 'word.tag'])
                ->orderBy('word_number')
                ->first();
        }

        return response()->json($nextUnfamiliarWord->word);
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
            $userWord->is_favorite = !$userWord->is_favorite;
        } elseif ($status === 'memorized') {
            $userWord->is_memorized = !$userWord->is_memorized;
        }

        $userWord->save();

        return response()->json($userWord);
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