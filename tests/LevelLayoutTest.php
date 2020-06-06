<?php

namespace EquineSolutions\Filemaker\Tests;

use airmoi\FileMaker\Command\Find;
use airmoi\FileMaker\FileMaker;
use EquineSolutions\Filemaker\Exceptions\MethodNotAllowed;
use EquineSolutions\Filemaker\Tests\TestCase as TestCase;

class LevelLayoutTest extends TestCase
{
    /** @test */
    public function it_fetches_a_single_record()
    {
        $layout = new LevelLayout();

        $data = $layout->index()->first()->get()['data'];

        $this->assertCount(1, $data);

        foreach ($layout->getFieldsMap() as $key => $value){
            $this->assertArrayHasKey($key, $data[0]);
        }
    }

    /** @test */
    public function it_fetches_a_list_of_layouts_using_pagination()
    {
        $layout = new LevelLayout();

        $response = $layout->index()->paginate(2)->get();

        $data = $response['data'];

        $this->assertEquals($response['next_page'], true);

        $this->assertCount(2, $data);

        foreach ($data as $item){
            foreach ($layout->getFieldsMap() as $key => $value){
                $this->assertArrayHasKey($key, $item);
            }
        }
    }

    /** @test */
    public function it_fetches_a_list_of_layouts_using_pagination_using_sort_asc()
    {
        $layout = new LevelLayout();

        $response = $layout->index()->sort($layout->getFieldsMap()['id'])->paginate(2)->get();

        $data = $response['data'];

        $this->assertEquals($response['next_page'], true);

        $this->assertCount(2, $data);

        $this->assertLessThan($data[1]['id'], $data[0]['id']);

        foreach ($data as $item){
            foreach ($layout->getFieldsMap() as $key => $value){
                $this->assertArrayHasKey($key, $item);
            }
        }
    }

    /** @test */
    public function it_fetches_a_list_of_layouts_using_pagination_using_sort_desc()
    {
        $layout = new LevelLayout();

        $response = $layout->index()->sort($layout->getFieldsMap()['id'], 'desc')->paginate(2)->get();

        $data = $response['data'];

        $this->assertEquals($response['next_page'], true);

        $this->assertCount(2, $data);

        $this->assertLessThan($data[0]['id'], $data[01]['id']);

        foreach ($data as $item){
            foreach ($layout->getFieldsMap() as $key => $value){
                $this->assertArrayHasKey($key, $item);
            }
        }
    }


    /** @test */
    public function it_fetches_a_list_of_layouts_with_array_of_filter()
    {
        $layout = new LevelLayout();

        $data = $layout->index()->filter(
            [
                $layout->getFieldsMap()['id'] => 1,
            ])->get()['data'];

        $this->assertCount(1, $data);

        foreach ($layout->getFieldsMap() as $key => $value){
            $this->assertArrayHasKey($key, $data[0]);
        }
    }

    /** @test */
    public function it_tries_to_insert_a_single_record_but_fails_and_catches_invalid_data_exception()
    {
        $layout = new LevelLayout();

        $this->expectException(MethodNotAllowed::class);

        $layout->create([]);
    }


    /** @test */
    public function it_tries_to_update_a_single_record_but_fails_and_catches_invalid_data_exception()
    {
        $layout = new LevelLayout();

        $this->expectException(MethodNotAllowed::class);

        $layout->edit(1, []);
    }
}