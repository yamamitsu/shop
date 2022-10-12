<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * BCP入力書式内の設問構造のモデル
 */
class MFormuraQuestions extends Model
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
    public $incrementing = false;

	/**
	 * 指定した書式指定IDに関連付けられた章IDリストを取得する
	 *
     * @param int $formula_id 入力書式ID
	 * @return MChapter 商品Entityリスト（作成不可な場合false）
	 */
    public function findMChapters(int $formula_id = 1)
    {
        $this->belongsToMany(MFormula::class);
        $this->belongsToMany(MChapter::class);
        $this->belongsToMany(MQuestion::class);
    }



}
