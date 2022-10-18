<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 入力内容entriesレコードに関連付けられた画像データのモデル
 */
class EntryImage extends Model
{
    use HasFactory;
    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'entry_images';
    /**
     * テーブルに関連付ける主キー
     *
     * @var string
     */
    protected $primaryKey = 'entry_id';

    protected $fillable = [
        'cid',
        'content',
        'memo',
    ];

    protected $guarded = [
        'entry_id',
    ];
}
