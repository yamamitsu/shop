<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MFormula;
use App\Models\MChapter;
use App\Models\Entry;
use App\Http\Requests\NormalPageFormRequest;

class MChapterController extends Controller
{
    /**
     * 目次(章一覧)ページの表示
     */
    public function index () 
    {
        // TODO: 書式IDを選択する昨日やページなどを後日作成する(おそらくCSS様が特定のformulaIdを指定し、利用者は意識する必要のない方式)
        $formula_id = 1;
        MFormula::setCurrentId($formula_id);

        // 指定した書式IDから章一覧を取得してviewに渡す
        $fm = MFormula::find($formula_id);
        $chapters = $fm->chapters()->get();


        return view('mchapter/index', compact('chapters'));
    }

    /**
     * 特定の章の入力欄を表示
     */
    public function view (int $chapter_id)
    {
        // 指定した書式IDから設問一覧を取得してviewに渡す
        $formula_id = MFormula::getCurrentId();
        $fm = MFormula::find($formula_id);
        $questions = $fm->questions($chapter_id)->get();
        $chapter = MChapter::find($chapter_id);
        $document_id = 1; // TODO

        return view('mchapter/view', compact('document_id', 'chapter', 'questions'));
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
            return redirect()->action('App\Http\Controllers\MChapterController@view', ['chapter_id' => $chapter_id]);
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

        return view('mchapter/confirm', compact('document_id', 'chapter', 'questions'));
    }
}
