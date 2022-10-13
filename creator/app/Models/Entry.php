<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * BCPオンラインの各章、各項目の入力内容entriesテーブルのモデル
 * 
 * ユーザーが入力する最小単位となる
 */
class Entry extends Model
{
    use HasFactory;
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'entries';
    /**
     * テーブルに関連付ける主キー
     *
     * @var string
     */
    protected $primaryKey = 'entry_id';

    protected $fillable = [
        'cid',
        'document_id',
        'chapter_id',
        'question_id',
        'branch_id',
        'content',
    ];

    protected $guarded = [
        'entry_id',
    ];
}
