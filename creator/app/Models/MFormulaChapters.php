<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * BCP入力書式内の章構造のモデル
 */
class MFormuraChapters extends Model
{
    use HasFactory;
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'm_formula_chapters';
    /**
     * テーブルに関連付ける主キー
     *
     * @var string
     */
    protected $primaryKey = ['formula_id', 'chapter_id'];
    public $incrementing = false;
}
