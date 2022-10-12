<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MFormula;


class MChapterController extends Controller
{
    /**
     * 目次(章一覧)ページの表示
     */
    public function index () 
    {
        // 指定した書式IDから章一覧を取得してviewに渡す
        $fm = MFormula::find(1);
        $chapters = $fm->chapters()->get();


        return view('mchapter/index', compact('chapters'));
    }

    /**
     * 特定の章の入力欄を表示
     */
    public function view (int $chapter_id)
    {
        // 指定した書式IDから設問一覧を取得してviewに渡す
        $fm = MFormula::find(1);
        $questions = $fm->questions($chapter_id)->get();

        return view('mchapter/view', compact('chapter_id', 'questions'));
    }

}
