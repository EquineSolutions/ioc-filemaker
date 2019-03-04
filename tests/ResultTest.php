<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 3/2/19
 * Time: 11:58 AM
 */

namespace EquineSolutions\IOCFilemaker\Tests;


use EquineSolutions\IOCFilemaker\Exceptions\MethodNotAllowed;
use EquineSolutions\IOCFilemaker\Layouts\Result;

class ResultTest extends TestCase
{
    /** @test */
    public function it_fetches_a_single_record_from_filemaker_without_mockery_to_check_fields_names()
    {
        $result = (new Result())->first()->get();
        $this->assertEquals(sizeof($result), 1);
    }

    /** @test */
    public function it_inserts_a_single_record()
    {
        $filemaker = \Mockery::mock('Filemaker');
        $add = \Mockery::mock('Add');

        $add->shouldReceive('execute')->andReturn($add);
        $add->shouldReceive('getRecords')->andReturn([]);
        $filemaker->shouldReceive('newAddCommand')->once()->andReturn($add);

        $result = new Result();
        $result->setFilemaker($filemaker);

        $this->assertEquals($result->create([])->post(), ['data'=>[]]);
    }

    /** @test */
    public function it_tries_to_insert_a_single_record_but_fails_and_catches_invalid_data_exception()
    {
        $filemaker = \Mockery::mock('Filemaker');

        $result = new Result();
        $result->setFilemaker($filemaker);

        $this->expectException(MethodNotAllowed::class);
        $this->assertEquals($result->create([])->post(), ['data'=>[]]);
    }
}