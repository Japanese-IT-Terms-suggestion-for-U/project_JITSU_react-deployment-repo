<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use App\Models\UserTag;
use Illuminate\Http\Request;

class UserTagController extends Controller
{
    public function getUserTags()
    {
        $user = Auth::user();
        $tags = UserTag::where('user_id', $user->id)->get()->pluck('tag.tag_name')->toArray();

        return response()->json($tags);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $tagsInput = $request->input('tags');

        // 아무 태그도 선택하지 않은 경우, 'OS'를 기본 선택으로 합니다.
        if (empty($tagsInput)) {
            $tagsInput = ['OS'];
        }

        // 기존 태그 삭제
        UserTag::where('user_id', $user->id)->delete();

        // 새로운 태그 추가
        foreach ($tagsInput as $tagName) {
            $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
            UserTag::create(['user_id' => $user->id, 'tag_id' => $tag->tag_id]);
        }

        return back()->with('status', '태그가 업데이트되었습니다.');
    }
}
