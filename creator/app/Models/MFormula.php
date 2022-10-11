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
}
