<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * BCP書式により生成されたBCP書類本体のテーブルのモデル
 * 
 * 将来的に[BCP書式]->[特定の事業者用のBCP雛形]->[事業所各拠点の実際のBCP書類]
 */
class Document extends Model
{
    use HasFactory;
    const SESSION_DOCUMENT_ID = '_document_id';
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'documents';
    /**
     * テーブルに関連付ける主キー
     *
     * @var string
     */
    protected $primaryKey = 'document_id';

    protected $fillable = ['cid','formula_id','version','first_id','memo'];

    /**
     * 現在の書類IDを返す
     * 
     * 大半のページでdocument_idは固定値となるため、SESSIONに保存して読み出す方式とする。
     *
     * @return int 現在の書類ID
     */
    public static function getCurrentId()
    {
        $document_id = session()->get(Document::SESSION_DOCUMENT_ID);
        return $document_id ?? 1;
    }

    /**
     * 現在の書類IDを返す
     * 
     * @return Document 現在のドキュメント
     */
    public static function getCurrent()
    {
        return Document::find(Document::getCurrentId());
    }

    /**
     * 書類IDを設定する
     *
     * @param integer $document_id 書類ID
     * @return void
     */
    public static function setCurrentId(int $document_id)
    {
        return session()->put(Document::SESSION_DOCUMENT_ID, $document_id);
    }

    /** document_idに関連付けられた入力内容リストを取得する */
    public function entries()
    {
        return $this->hasMany(
            Entry::class,
            'entry_id',
            'document_id'
        );
    }

    /**
     * 入力内容entriesのレコードをbranch_idの連想配列にして返す
     *
     * @return Array<Entry> 0:questionに対する追加のentry登録(branch_idの割当がない) 1>=:branch_idをkeyとした連想配列
     */
    public function entriesForBranches()
    {
        $entries = $this->hasMany(
            Entry::class,
            'document_id',
            'document_id'
        )->with('image')->get();
        if (!$entries) {
            return false;
        }
        $entriesForBranches = [0 => []];
        foreach($entries as $e) {
            if ($e->branch_id) {
                $entriesForBranches[$e->branch_id] = $e;
            } else {
                $entriesForBranches[0][] = $e;

            }
        }
        return $entriesForBranches;
    }

}
