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
        $hello = 'Hello,World!';
        $hello_array = ['Hello', 'こんにちは', 'ニーハオ'];

        $fm = MFormula::find(1);
        $chapters = $fm->chapters()->get();


        return view('mchapter', compact('hello', 'hello_array', 'chapters'));
    }

    public function view (int $chapter_id)
    {

    }

}
