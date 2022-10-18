<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\BcpFormController;
use App\Http\Controllers\DocumentController;
//use App\Http\Controllers\MapUploadController;
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
Route::get('/hello', [HelloController::class, 'index']);
// 目次(章一覧)
Route::get('/chapter', [ChapterController::class, 'index']);

// BCP本文入力欄表示(章表示)
Route::get('/bcpform/{chapter_id}', [BcpFormController::class, 'view']);
// BCP本文１章分の入力結果の表示
Route::post('/bcpform/confirm/{chapter_id}', [BcpFormController::class, 'confirm']);

// 入力内容に関連付けられた画像の表示
Route::get('/document/showImage/{entry_id}', [DocumentController::class, 'showImage']);
// // 地図画像入力ページの表示
// Route::get('/mapupload/{chapter_id}', [MapUploadController::class, 'view']);
// // 地図画像入力ページの入力結果の表示
// Route::post('/mapupload/confirm/{chapter_id}', [MapUploadController::class, 'confirm']);
