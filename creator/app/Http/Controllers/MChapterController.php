<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MFormula;
use App\Models\MChapter;

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

        return view('mchapter/view', compact('chapter', 'questions'));
    }
}
