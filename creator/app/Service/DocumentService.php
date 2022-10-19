<?php

namespace App\Service;

use Storage;
use App\Entity\DocumentContext;
use App\Models\Document;
use App\Models\Entry;
use App\Models\EntryImage;
use App\Models\MChapter;
use App\Models\MFormula;

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
}
