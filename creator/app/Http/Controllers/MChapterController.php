<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MChapter;


class MChapterController extends Controller
{
    public function index () 
    {
        $hello = 'Hello,World!';
        $hello_array = ['Hello', 'こんにちは', 'ニーハオ'];
        $mchapter = new MChapter;
        $m = $mchapter->find(1);


        return view('mchapter', compact('hello', 'hello_array', 'm'));
    }
}
