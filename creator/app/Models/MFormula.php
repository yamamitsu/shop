<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * BCPの書式全体を「BCP入力書式」として規定し、IDを割り当てたm_formulaテーブルのモデル
 */
class MFormula extends Model
{
    use HasFactory;
    const SESSION_FORMULA_ID = '_formula_id';
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'm_formula';
    /**
     * テーブルに関連付ける主キー
     *
     * @var string
     */
    protected $primaryKey = 'formula_id';

    /**
     * 現在の書式IDを返す
     * 
     * 大半のページでformula_idは固定値となるため、SESSIONに保存して読み出す方式とする。
     *
     * @return void
     */
    public static function getCurrentId()
    {
        $formula_id = session()->get(MFormula::SESSION_FORMULA_ID);
        return $formula_id ?? 1;
    }
    /**
     * 書式IDを設定する
     *
     * @param integer $formula_id 書式ID
     * @return void
     */
    public static function setCurrentId(int $formula_id)
    {
        return session()->put(MFormula::SESSION_FORMULA_ID, $formula_id);
    }

    /** m_formulaに関連付けられた章リストを取得する */
    public function chapters()
    {
        return $this->belongsToMany(
            MChapter::class, 
            'm_formula_chapters',
            'formula_id', 
            'chapter_id'
            )->withPivot('idx')
            ->orderBy('m_formula_chapters.priority', 'DESC');
    }

    /** formula_id, chapter_idに関連付けられたquestionsを取得する */
    public function questions(int $chapter_id)
    {
        return $this->belongsToMany(
            MQuestion::class, 
            'm_formula_questions',
            'formula_id', 
            'question_id'
            )
            ->where('main_chapter_id', $chapter_id)
            ->orderBy('m_formula_questions.priority', 'DESC');
    }
}
