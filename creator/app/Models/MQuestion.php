<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * BCPの設問定義であるm_questionsテーブルのモデル
 */
class MQuestion extends Model
{
    use HasFactory;
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'm_questions';
    /**
     * テーブルに関連付ける主キー
     *
     * @var string
     */
    protected $primaryKey = 'question_id';

    /** formula_id, chapter_idに関連付けられたquestionsを取得する */
    public function branches()
    {
        return $this->hasMany(
            MBranch::class,
            'branch_id',
            'question_id'
        );
    }
}
