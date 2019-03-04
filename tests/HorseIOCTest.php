<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 3/2/19
 * Time: 11:46 AM
 */

namespace EquineSolutions\IOCFilemaker\Tests;


use EquineSolutions\IOCFilemaker\Exceptions\MethodNotAllowed;
use EquineSolutions\IOCFilemaker\Layouts\HorseIOC;

class HorseIOCTest extends TestCase
{
    /** @test */
    public function it_fetches_a_single_record_from_filemaker_without_mockery_to_check_fields_names()
    {
        $horse = (new HorseIOC())->first()->get();
        $this->assertEquals(sizeof($horse), 1);
    }

    /** @test */
    public function it_inserts_a_single_record()
    {
        $filemaker = \Mockery::mock('Filemaker');
        $add = \Mockery::mock('Add');

        $add->shouldReceive('execute')->andReturn($add);
        $add->shouldReceive('getRecords')->andReturn([]);
        $filemaker->shouldReceive('newAddCommand')->once()->andReturn($add);

        $horse = new HorseIOC();
        $horse->setFilemaker($filemaker);

        $this->assertEquals($horse->create([])->post(), ['data'=>[]]);
    }

    /** @test */
    public function it_tries_to_insert_a_single_record_but_fails_and_catches_invalid_data_exception()
    {
        $filemaker = \Mockery::mock('Filemaker');

        $horse = new HorseIOC();
        $horse->setFilemaker($filemaker);

        $this->expectException(MethodNotAllowed::class);
        $this->assertEquals($horse->create([])->post(), ['data'=>[]]);
    }
}