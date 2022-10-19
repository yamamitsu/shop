<?php

namespace App\Entity;

/**
 * 現在のドキュメント及び書式の位置
 */
class DocumentContext
{
    // /**
    //  * BCP書式ID
    //  *
    //  * @var int
    //  */
    // public $formula_id;
    // /**
    //  * 章ID
    //  *
    //  * @var int
    //  */
    // public $chapter_id;
    // /**
    //  * ドキュメントID
    //  *
    //  * @var int
    //  */
    // public $document_id;

    /**
     * @param int $formula_id BCP書式ID
     * @param int $chapter_id 章ID
     * @param int $document_id ドキュメントID
     */
    public function __construct(
        public $formula_id = null,
        public $chapter_id = null,
        public $document_id = null
    ) {}
}
