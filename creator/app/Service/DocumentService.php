<?php

namespace App\Service;

use Storage;
use App\Entity\DocumentContext;
use App\Models\Document;
use App\Models\Entry;
use App\Models\EntryImage;
use App\Models\MChapter;
use App\Models\MFormula;
use App\Models\MFormulaQuestions;

/**
 * ドキュメントサービス
 * 
 * ドキュメントの作成、データ取得、PDF出力などのビジネスロジックをここに実装する。
 * Service系クラスは単体テストを実装し、品質を確保する。
 */
class DocumentService
{
    /**
     * 指定したBCP書式の章に登録された設問および選択肢を取得する
     * 
     * ただし設問にcontollerが設定されている場合は処理を中断する
     * @param DocumentContext $doccont
     * @return void
     */
    public function getQuestionsOfChapterWithCheck(DocumentContext $doccont)
    {
        $fm = MFormula::find($doccont->formula_id);
        $questions = $fm->questions($doccont->chapter_id)->with('branches')->get();

        // 章の設問でcontrollerが設定されている場合は処理を中断してControllerを返す
        foreach($questions as $i => $q) {
            if ($i == 0 && $q->controller) {
                return (object)[
                    'redirect' => true,
                    'controller' => $q->controller
                ];
            }
        }

        $document_id = $doccont->document_id;
        $chapter = MChapter::find($doccont->chapter_id);
        $document = Document::find($doccont->document_id);
        $entries = $document->entriesForBranches();

        return (object)[
            'redirect' => false,
            'compact' => compact('document_id', 'chapter', 'questions', 'entries')
        ];
    }

    /**
     * 入力内容テーブルentriesにレコードを保存または更新する
     *
     * @param DocumentContext $doccont
     * @param array $entry
     * @return int entries.entry_id
     */
    public function saveEntry(DocumentContext $doccont, array $entry)
    {
        $en = new Entry;
        $en->fill([
            'cid' => $doccont->cid,
            'document_id' => $doccont->document_id,
            'chapter_id' => $doccont->chapter_id,
            'question_id' => $entry['question_id'],
            'branch_id' => isset($entry['branch_id']) ? $entry['branch_id'] : null,
        ]);
        if (isset($entry['content']) && $entry['content']) {
            $en->content = $entry['content'];
        }
        // entry_idが存在する場合は既存データなので上書処理に切り替える
        if (isset($entry['entry_id']) && $entry['entry_id']) {
            $en->entry_id = $entry['entry_id'];
            $en->exists = true;
        }
        $en->save();
        return $en->entry_id;
    }

    /**
     * 入力内容テーブルentriesのレコードを削除する
     *
     * @param int $entry_id
     */
    public function deleteEntry($entry_id)
    {
        return Entry::where('entry_id', $entry_id)->delete();
    }

    /**
     * 入力内容添付ファイルテーブルentriy_imagesにレコードを保存または更新する
     *
     * @param DocumentContext $doccont
     * @param int $entry_id
     * @param array $entry
     * @param UploadedFile $file
     * @return int entries.entry_id
     */
    public function saveEntryImage(DocumentContext $doccont, int $entry_id, array $entry, $file)
    {
        $path = $file->store('public'); // e.g. $path='public/XXXXX.jpg';
        $path = substr($path, 7);
        // アップロードされたファイルデータの取得
        $content = Storage::Disk('public')->get($path);
        $im = new EntryImage;
        $im->fill([
            'entry_id' => $entry_id,
            'cid' => $doccont->cid,
            'content' => $content,
            'content_path' => $path,
        ]);
        if (EntryImage::find($entry_id)) {
            $im->exists = true;
        }
        $im->save();
    }

    /**
     * 入力内容添付ファイルテーブルentriy_imagesのレコードを削除する
     *
     * @param int $entry_id
     */
    public function deleteEntryImage($entry_id)
    {
        return EntryImage::where('entry_id', $entry_id)->delete();
    }
}
