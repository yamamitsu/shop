<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MFormula;
use App\Models\MChapter;
use App\Models\Entry;
use App\Http\Requests\NormalPageFormRequest;

/**
 * BCP本文の入力ページの表示および登録機能を提供する
 * 
 * ChapterController - 目次のページ
 * DocumentController - 作成／編集するドキュメントを選択するページ
 * BcpFormController - BCP本文を作成／編集するページ
 * MapUploadController - 地図画像を登録するページ
 */
class BcpFormController extends Controller
{
    /**
     * 特定の章の入力欄を表示
     */
    public function view (int $chapter_id)
    {
        // 指定した書式IDから設問一覧を取得してviewに渡す
        $formula_id = MFormula::getCurrentId();
        $fm = MFormula::find($formula_id);
        $sql = $fm->questions($chapter_id)->toSql();
        $questions = $fm->questions($chapter_id)->get();
        $chapter = MChapter::find($chapter_id);
        $document_id = 1; // TODO

        foreach($questions as $i => $q) {
            if ($i == 0 && $q->controller) {
                return redirect()->action(
                    "App\\Http\\Controllers\\{$q->controller}Controller@view", 
                    ['chapter_id' => $chapter_id]
                );
            }
        }

        return view('bcpform/bcpform_view', compact('document_id', 'chapter', 'questions'));
    }

    /**
     * 特定の章の入力欄を表示
     */
    public function confirm (NormalPageFormRequest $request, int $chapter_id)
    {
        // 指定した書式IDから設問一覧を取得してviewに渡す
        $formula_id = MFormula::getCurrentId();
        $entries = $request->input('entries');
        if (!$entries) {
            return redirect()->action('App\Http\Controllers\BcpFormController@view', ['chapter_id' => $chapter_id]);
        }
        // TODO: Service系にこの実装を移譲させる必要がある
        foreach($entries as $entry) {
            //$en = new Entry;
            $en = Entry::firstOrNew([
                'cid' => 1, // TODO
                'document_id' => 1, // TODO
                'chapter_id' => $chapter_id,
                'question_id' => $entry['question_id'],
                'branch_id' => $entry['branch_id'],
                'content' => $entry['content'],
            ]);
            if (isset($entry['entry_id']) && $entry['entry_id']) {
                $en->entry_id = $entry['entry_id'];
                $en->exists = true;
            }
            $en->save();
        }
        $fm = MFormula::find($formula_id);
        $questions = $fm->questions($chapter_id)->get();
        $chapter = MChapter::find($chapter_id);
        $document_id = 1; // TODO

        return view('bcpform/bcpform_confirm', compact('document_id', 'chapter', 'questions'));
    }
}
