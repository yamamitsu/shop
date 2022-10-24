<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * BCP入力書式内の設問構造のモデル
 */
class MFormulaQuestions extends Model
{
    use HasFactory;
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'm_formula_questions';
    /**
     * テーブルに関連付ける主キー
     *
     * @var string
     */
    protected $primaryKey = ['formula_id', 'chapter_id', 'question_id'];
    protected $fillable = ['formula_id', 'chapter_id', 'main_chapter_id', 'question_id'];
    public $incrementing = false;

	/**
	 * 指定した書式指定IDに関連付けられた章リストおよび設問一覧を取得する
	 *
     * @param int $formula_id 入力書式ID
	 * @return MChapter 商品Entityリスト（作成不可な場合false）
	 */
    public static function findChaptersAndQuestionsOfFormula(int $formula_id = 1)
    {
        return MFormulaQuestions::where('formula_id', $formula_id)
            //->with('chapter')
            ->with('question')
            ->orderBy('priority', 'DESC');
    }

    public function chapter()
    {
        return $this->hasOne(MChapter::class, 'chapter_id', 'chapter_id');
    }
    public function question()
    {
        return $this->hasOne(MQuestion::class, 'question_id', 'question_id');
    }
}
