<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery as m;
use App\Service\DocumentService;
use App\Entity\DocumentContext;
use App\Models\MFormula;
use App\Models\MChapter;
use App\Models\MQuestion;
use App\Models\Document;

class DocumentServiceTest extends TestCase
{
    /** @var DocumentService */
    public $documentService;
    /** @var DocumentContext */
    public $documentContext;
    // Mocks
    public $mockMFormula;
    public function setUp():void
    {
        parent::setUp();
        $this->documentService = new DocumentService();
        $this->documentContext = new DocumentContext(11,12,13,14);
        $this->mockMFormula = m::mock('alias:' . MFormula::class);
        $this->mockMFormula->shouldReceive('find')->andReturn(
            $this->mockMFormula
        );
        // $this->mockMFormula = m::mock(MFormula::class);
        // $this->mockMFormula->shouldReceive('find')->andReturn(
        //     $this->mockMFormula
        // );
        $this->mockMFormula->shouldReceive('questions')->andReturn(
            $this->mockMFormula
        );
        $this->mockMFormula->shouldReceive('with')->andReturn(
            $this->mockMFormula
        );
        // $this->mockMFormula->shouldReceive('get')->andReturn(
        //     $this->mockMFormula
        // );

        $this->mockMChapter = m::mock('alias:' . MChapter::class);
        $this->mockMChapter->shouldReceive('find')->andReturn(
            (object)['chapter_id' => 12]
        );
        $this->mockDocument = m::mock('alias:' . Document::class);
        $this->mockDocument->shouldReceive('find')->andReturn(
            $this->mockDocument
        );
        $this->mockDocument->shouldReceive('entriesForBranches')->andReturn(
            [1 => (object)['entry_id' => 15]]
        );

    }
    /**
     * DocumentService::getQuestionsOfChapterWithCheck()
     * 実行時にControllerへのリダイレクトを返す場合の動作の確認
     *
     * @return void
     */
    public function test_getQuestionsOfChapterWithCheck_failed()
    {
        $this->mockMFormula->shouldReceive('get')->andReturn(
            [(object)[
                'question_id' => 114,
                'controller' => 'Some'
            ]]
        );
        $questions = $this->documentService->getQuestionsOfChapterWithCheck($this->documentContext);
        $this->assertEquals($questions, (object)[
            'redirect' => true,
            'controller' => 'Some'
        ]);
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_getQuestionsOfChapterWithCheck_successed()
    {
        $this->mockMFormula->shouldReceive('get')->andReturn(
            []
        );
        $questions = $this->documentService->getQuestionsOfChapterWithCheck($this->documentContext);
        $this->assertEquals($questions, (object)[
            'redirect' => false,
            'compact' => [
                'document_id' => 13,
                'chapter' => (object)['chapter_id' => 12],
                'questions' => [],
                'entries' => [
                    1 => (object)['entry_id' => 15]
                ],
            ]
        ]);
    }
}
