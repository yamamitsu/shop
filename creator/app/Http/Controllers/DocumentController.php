<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;
use App\Models\Entry;
use App\Models\EntryImage;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * 選択したBCPドキュメントを表示したり印刷するコントローラー
 * 
 */
class DocumentController extends Controller
{
    public function preview($entry_id)
    {
        return view('pdf_template/document_preview', compact('entry_id'));
    }
    public function download($entry_id)
    {
        $pdf = Pdf::loadView('pdf_template/document_preview', compact('entry_id'));
        $pdf->setPaper('A4', 'portrait');
        // $pdf->render();
        // $pdf->loadView('pdf_template/document_preview', compact('entry_id'));
        // $pdf->setPaper('A4', 'landscape');
        return $pdf->download('invoice.pdf');
    }
    /**
     * BCP文書の目次ページのプレビュー表示
     */
    public function chapter()
    {
        return view('pdf_template/document_chapter', []);
    }
    public function chapterDownload()
    {
        $pdf = Pdf::loadView('pdf_template/document_chapter', []);
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download('chapter.pdf');
    }
    /**
     * entry_imagesに格納された画像データを返す(imageタグ用)
     *
     * @param [type] $entry_id
     * @return void
     */
    public function showImage($entry_id)
    {
        $image = EntryImage::find($entry_id);
        if (!$image || !$image->content) {
            return abort(404);
        }
        // DBのblobに入っている画像データをStorageに書き出す
        $will_be_put = true;
        if ($image->content_path) {
            // Storageに保存された画像データのチェック
            $content = Storage::disk('public')->get($image->content_path);
            if ($content == $image->content) {
                $will_be_put = false;
            }
        }
        if ($will_be_put) {
            $image->content_path = md5(microtime());
            Storage::disk('public')->put($image->content_path, $image->content);
            $image->save();
        }
        // Storageに保存された画像のフルパス
        $image_path = sprintf('%s/%s', storage_path('app/public'), $image->content_path);
        switch(exif_imagetype($image_path)) { // 画像形式の判別
            case IMAGETYPE_WEBP:
                $contentType = 'image/webp';
                break;
            case IMAGETYPE_PNG:
                $contentType = 'image/png';
                break;
            default: case IMAGETYPE_JPEG:
                $contentType = 'image/jpeg';
                break;
        }
        return response($image->content, 200)->header('Content-Type', $contentType);
    }
}
