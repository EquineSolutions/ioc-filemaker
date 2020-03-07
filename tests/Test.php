<?php

namespace EquineSolutions\IOCFilemaker\Tests;

use EquineSolutions\IOCFilemaker\Layouts\TestLayout;

class Test extends TestCase
{

    /** @test */
    public function it_fetches_a_single_record_from_filemaker_without_mockery_to_check_fields_names()
    {
    }

    /** @test */
    public function it_gets_a_single_record()
    {
        $filemaker = \Mockery::mock('Filemaker');
        $add = \Mockery::mock('Find');

        $add->shouldReceive('execute')->andReturn($add);
        $add->shouldReceive('getRecords')->andReturn([]);
        $add->shouldReceive('addSortRule')->andReturn([]);
        $add->shouldReceive('getRange')->andReturn([]);
        $filemaker->shouldReceive('newFindCommand')->once()->andReturn($add);

        $show = new TestLayout();
        $show->setFilemaker($filemaker);

        $this->assertEquals($show->index()->get(), ['data'=>[]]);
    }

    /**
     * @inheritDoc
     */
    public function it_inserts_a_single_record()
    {
        // TODO: Implement it_inserts_a_single_record() method.
    }
}
