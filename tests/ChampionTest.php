<?php

namespace EquineSolutions\IOCFilemaker\Tests;


use EquineSolutions\IOCFilemaker\Exceptions\MethodNotAllowed;
use EquineSolutions\IOCFilemaker\Layouts\Champion;

class ChampionTest extends TestCase
{
    /** @test */
    public function it_fetches_a_single_record_from_filemaker_without_mockery_to_check_fields_names()
    {
        $champion = (new Champion())->first()->get();
        $this->assertEquals(sizeof($champion), 1);
    }

    /** @test */
    public function it_inserts_a_single_record()
    {
        $filemaker = \Mockery::mock('Filemaker');
        $add = \Mockery::mock('Add');

        $add->shouldReceive('execute')->andReturn($add);
        $add->shouldReceive('getRecords')->andReturn([]);
        $filemaker->shouldReceive('newAddCommand')->once()->andReturn($add);

        $champion = new Champion();
        $champion->setFilemaker($filemaker);

        $this->assertEquals($champion->create([])->post(), ['data'=>[]]);
    }

    /** @test */
    public function it_tries_to_insert_a_single_record_but_fails_and_catches_invalid_data_exception()
    {
        $filemaker = \Mockery::mock('Filemaker');

        $champion = new Champion();
        $champion->setFilemaker($filemaker);

        $this->expectException(MethodNotAllowed::class);
        $this->assertEquals($champion->create([])->post(), ['data'=>[]]);
    }
}