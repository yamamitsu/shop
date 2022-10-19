<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\NormalPageFormRequest;
use App\Service\DocumentService;
use App\Entity\DocumentContext;
use App\Models\Document;
use App\Models\Entry;
use App\Models\EntryImage;
use App\Models\MChapter;
use App\Models\MFormula;

/**
 * BCP本文の入力ページの表示および登録機能を提供する
 * 
 * ChapterController - 目次のページ
 * DocumentController - 作成／編集するドキュメントを選択するページ
 * BcpFormController - BCP本文を作成／編集するページ
 * MapUploadController - 地図画像を登録するページ
 */
class BcpFormController extends Controller
{
    /** @var DocumentService */
    private $documentService;

    public function __construct(
        DocumentService $documentService
    ) {
        $this->documentService = $documentService;
    }
    /**
     * 特定の章の入力欄を表示
     */
    public function view (int $chapter_id)
    {
        $doccont = new DocumentContext(MFormula::getCurrentId(), $chapter_id, Document::getCurrentId());
        $result = $this->documentService->getQuestionsOfChapterWithCheck($doccont);
        // Questionにcontrollerが設定されている場合は処理を中断してそのコントローラーにリダイレクトする
        if ($result->redirect) {
            return redirect()->action(
                "App\\Http\\Controllers\\{$result->controller}Controller@view", 
                ['chapter_id' => $chapter_id]
            );
        }
        return view('bcpform/bcpform_view', $result->compact);
    }

    /**
     * 特定の章の入力欄を表示
     *
     * @param NormalPageFormRequest $request 
     * @param integer $chapter_id 章ID
     * @return void
     */
    public function confirm (NormalPageFormRequest $request, int $chapter_id)
    {
        // 指定した書式IDから設問一覧を取得してviewに渡す
        $formula_id = MFormula::getCurrentId();
        $document_id = Document::getCurrentId();
        $entries = $request->input('entries');

        // 入力内容がないのはおかしい
        if (!$entries) {
            return redirect()->action('App\Http\Controllers\BcpFormController@view', ['chapter_id' => $chapter_id]);
        }

        // TODO: Service系にこの実装を移譲させる必要がある
        foreach($entries as $i => $entry) {
            if (!isset($entry['for_image']) && !$entry['content'] && !isset($entry['entry_id'])) {
                continue; // 入力欄が空の追加入力欄は無視する
            }
            $en = null;
            if (array_key_exists('deleted', $entry) && $entry['deleted']) { // 手動追加項目の削除
                Entry::where('entry_id', $entry['entry_id'])->delete();
            } else {
                $en = new Entry;
                $en->fill([
                    'cid' => 1, // TODO
                    'document_id' => $document_id,
                    'chapter_id' => $chapter_id,
                    'question_id' => $entry['question_id'],
                    'branch_id' => isset($entry['branch_id']) ? $entry['branch_id'] : null,
                ]);
                if (isset($entry['content']) && $entry['content']) {
                    $en->content = $entry['content'];
                }
                if (isset($entry['entry_id']) && $entry['entry_id']) {
                    $en->entry_id = $entry['entry_id'];
                    $en->exists = true;
                }
                $en->save();
            }

            // 画像がアップロードされている
            if (!isset($entry['for_image'])) {
                continue;
            }
            $entry_id = isset($entry['entry_id']) && $entry['entry_id'] ? $entry['entry_id'] : $en->entry_id;
            if (array_key_exists('deleted', $entry) && $entry['deleted']) { // 画像の削除
                EntryImage::where('entry_id', $entry_id)->delete();
                continue;
            }    
            $file = $request->file('entries');
            if (!isset($file[$i]['image'])) { // 画像が設定されていない
                continue;
            }
            $path = $file[$i]['image']->store('public'); // e.g. $path='public/XXXXX.jpg';
            $path = substr($path, 7);
            $content = Storage::Disk('public')->get($path);
            $im = new EntryImage;
            $im->fill([
                'entry_id' => $entry_id,
                'cid' => 1, // TODO
                'content' => $content,
                'content_path' => $path,
            ]);
            if (EntryImage::find($entry_id)) {
                $im->exists = true;
            }
            $im->save();
        }
        $fm = MFormula::find($formula_id);
        $questions = $fm->questions($chapter_id)->with('branches')->get();
        $chapter = MChapter::find($chapter_id);
        $document = Document::find($document_id);
        $entries = $document->entriesForBranches();
        
        return view('bcpform/bcpform_view', compact('document_id', 'chapter', 'questions', 'entries'));
    }
}
