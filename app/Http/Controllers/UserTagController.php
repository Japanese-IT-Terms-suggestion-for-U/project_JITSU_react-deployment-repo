<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use App\Models\Tag;
use App\Models\UserTag;
use Illuminate\Http\Request;

class UserTagController extends Controller
{
    /**
     * @Route("/profile/get-user-tags", name="profile.tags.get")
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserTags(): JsonResponse
    {
        $user = Auth::user();
        $tags = UserTag::with('tag')->where('user_id', $user->id)->get()->pluck('tag.tag_name')->toArray();

        return response()->json($tags);
    }

    /**
     * @Route("/profile/tags-update", name="profile.tags.update")
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $tagsInput = $request->input('tags');

        // 아무 태그도 선택하지 않은 경우, 'OS'를 기본 선택으로 합니다.
        if (empty($tagsInput)) {
            $tagsInput = ['OS'];
        }

        DB::beginTransaction();

        try {
            // 기존 태그 삭제
            UserTag::where('user_id', $user->id)->delete();

            // 새로운 태그 추가
            foreach ($tagsInput as $tagName) {
                $tag = Tag::firstOrCreate(['tag_name' => $tagName]);
                UserTag::create(['user_id' => $user->id, 'tag_id' => $tag->id]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['msg' => '태그 업데이트에 실패하였습니다.']);
        }

        return back()->with('status', '태그가 업데이트되었습니다.');
    }

}
