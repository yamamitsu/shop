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
Route::get('/chapter', 'App\Http\Controllers\ChapterController@index');
// BCP本文入力欄表示(章表示)
Route::get('/bcpform/{chapter_id}', 'App\Http\Controllers\BcpFormController@view');
// BCP本文１章分の入力結果の表示
Route::post('/bcpform/confirm/{chapter_id}', 'App\Http\Controllers\BcpFormController@confirm');
// 地図画像入力ページの表示
Route::get('/mapupload/{chapter_id}', 'App\Http\Controllers\MapUploadController@view');
// 地図画像入力ページの入力結果の表示
Route::post('/mapupload/confirm/{chapter_id}', 'App\Http\Controllers\MapUploadController@confirm');
