<?php

namespace EquineSolutions\IOCFilemaker\Test;


use EquineSolutions\IOCFilemaker\Layouts\Show;
use EquineSolutions\IOCFilemaker\Tests\TestCase;

class ShowsTest extends TestCase
{

    /** @test */
    public function it_fetches_a_single_record_from_filemaker_without_mockery_to_check_fields_names()
    {
        $show = (new Show())->first()->get();
        $this->assertEquals(sizeof($show), 1);
    }

    /** @test */
    public function it_inserts_a_single_record()
    {
        $filemaker = \Mockery::mock('Filemaker');
        $add = \Mockery::mock('Add');

        $add->shouldReceive('execute')->andReturn($add);
        $add->shouldReceive('getRecords')->andReturn([]);
        $filemaker->shouldReceive('newAddCommand')->once()->andReturn($add);

        $show = new Show();
        $show->setFilemaker($filemaker);

        $this->assertEquals($show->create([])->post(), ['data'=>[]]);
    }
}