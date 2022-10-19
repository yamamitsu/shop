<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Entry;
use App\Models\MChapter;
use App\Models\MFormula;
use App\Models\MFormulaQuestions;

/**
 * BCP書式の章を表示するページのコントローラー
 * 
 * ChapterController - 目次のページ
 * DocumentController - 作成／編集するドキュメントを選択するページ
 * BcpFormController - BCP本文を作成／編集するページ
 * MapUploadController - 地図画像を登録するページ
 */
class ChapterController extends Controller
{
    /**
     * 目次(章一覧)ページの表示
     */
    public function index () 
    {
        // TODO: 書式IDを選択する昨日やページなどを後日作成する(おそらくCSS様が特定のformulaIdを指定し、利用者は意識する必要のない方式)
        $formula_id = 1;
        MFormula::setCurrentId($formula_id);
        $document_id = 1;
        Document::setCurrentId($document_id);
        if(!Document::find($document_id)) {
            Document::firstOrNew([
                'cid' => 1,
                'formula_id' => $formula_id,
                'memo' => 'テスト',
            ])->save();
        }

        // 指定した書式IDから章一覧を取得してviewに渡す
        $fm = MFormula::find($formula_id);
        $chapters = $fm->chapters()->get();

        $formulaQuestions = MFormulaQuestions::findChaptersAndQuestionsOfFormula($formula_id)->get();
        $questions = [];
        foreach($formulaQuestions as $fq) {
            if (!isset($questions[$fq->chapter_id])) {
                $questions[$fq->chapter_id] = $fq->question->question_id;
            }
        }


        return view('chapter/chapter_index', compact('chapters', 'questions'));
    }
}
