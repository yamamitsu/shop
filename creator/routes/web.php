<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// hello
Route::get('/hello', 'App\Http\Controllers\HelloController@index');
// 目次(章一覧)
Route::get('/mchapter', 'App\Http\Controllers\MChapterController@index');
// 入力欄表示(章表示)
Route::get('/mchapter/{chapter_id}', 'App\Http\Controllers\MChapterController@view');
// １ページ分の入力結果の表示
Route::post('/mchapter/confirm/{chapter_id}', 'App\Http\Controllers\MChapterController@confirm');
