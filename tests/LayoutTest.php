<?php

namespace EquineSolutions\Filemaker\Tests;

use airmoi\FileMaker\Command\Find;
use airmoi\FileMaker\FileMaker;
use EquineSolutions\Filemaker\Exceptions\MethodNotAllowed;
use EquineSolutions\Filemaker\Layouts\TestLayout;
use Orchestra\Testbench\TestCase as Orchestra;

class LayoutTest extends Orchestra
{

    public function tearDown() :void
    {
        \Mockery::close();
    }

    /** @test */
    public function it_fetches_a_list_of_layout_data()
    {
        $filemaker = \Mockery::mock(FileMaker::class);
        $find = \Mockery::mock(Find::class);

        $filemaker->shouldReceive('newFindCommand')->once()->andReturn($find);

        $find->shouldReceive('getRange')->andReturn(1);
        $find->shouldReceive('addSortRule');
        $find->shouldReceive('execute')->andReturn($find);
        $find->shouldReceive('getRecords')->andReturn([]);

        $testLayout = new TestLayout();
        $testLayout->setFilemaker($filemaker);

        $this->assertEquals($testLayout->index()->get(), ['data'=>[]]);

    }

    /** @test */
    public function it_fetches_a_list_of_layouts_using_pagination()
    {
        $filemaker = \Mockery::mock('Filemaker');
        $find = \Mockery::mock('Find');

        $find->shouldReceive('getRange')->andReturn(1);
        $find->shouldReceive('setRange');
        $find->shouldReceive('addSortRule');
        $find->shouldReceive('execute')->andReturn($find);
        $find->shouldReceive('getRecords')->andReturn([]);
        $filemaker->shouldReceive('newFindCommand')->once()->andReturn($find);

        $testLayout = new TestLayout();
        $testLayout->setFilemaker($filemaker);

        $this->assertEquals($testLayout->index()->paginate(5)->get(), ['data'=>[], 'next_page'=>false]);
    }

    /** @test */
    public function it_fetches_a_list_of_layouts_using_pagination_using_sort()
    {
        $filemaker = \Mockery::mock('Filemaker');
        $find = \Mockery::mock('Find');

        $find->shouldReceive('getRange')->andReturn(1);
        $find->shouldReceive('setRange');
        $find->shouldReceive('addSortRule');
        $find->shouldReceive('execute')->andReturn($find);
        $find->shouldReceive('getRecords')->andReturn([]);
        $filemaker->shouldReceive('newFindCommand')->once()->andReturn($find);

        $testLayout = new TestLayout();
        $testLayout->setFilemaker($filemaker);

        $this->assertEquals($testLayout->index()->paginate(5)->sort('id')->get(), ['data'=>[], 'next_page'=>false]);
    }

    /** @test */
    public function it_fetches_a_list_of_layouts_with_single_filter()
    {
        $filemaker = \Mockery::mock('Filemaker');
        $find = \Mockery::mock('Find');
        $find->shouldReceive('getRange')->andReturn(1);
        $find->shouldReceive('addFindCriterion');
        $find->shouldReceive('addSortRule');
        $find->shouldReceive('execute')->andReturn($find);
        $find->shouldReceive('getRecords')->andReturn([]);
        $filemaker->shouldReceive('newFindCommand')->once()->andReturn($find);

        $testLayout = new TestLayout();
        $testLayout->setFilemaker($filemaker);

        $this->assertEquals($testLayout->index()->filter('id', 1)->get(), ['data'=>[]]);
    }

    /** @test */
    public function it_fetches_a_list_of_layouts_with_array_of_filter()
    {
        $filemaker = \Mockery::mock('Filemaker');
        $find = \Mockery::mock('Find');
        $find->shouldReceive('getRange')->andReturn(1);
        $find->shouldReceive('addFindCriterion')->twice();
        $find->shouldReceive('addSortRule');
        $find->shouldReceive('execute')->andReturn($find);
        $find->shouldReceive('getRecords')->andReturn([]);
        $filemaker->shouldReceive('newFindCommand')->once()->andReturn($find);

        $testLayout = new TestLayout();
        $testLayout->setFilemaker($filemaker);

        $this->assertEquals($testLayout->index()->filter([
            'id' => 1,
            'name' => 'test',
        ])->get(), ['data'=>[]]);
    }

    /** @test */
    public function it_fetches_a_list_of_layouts_sorted_asc()
    {
        $filemaker = \Mockery::mock('Filemaker');
        $find = \Mockery::mock('Find');

        $find->shouldReceive('getRange')->andReturn(1);
        $find->shouldReceive('addSortRule');
        $find->shouldReceive('execute')->andReturn($find);
        $find->shouldReceive('getRecords')->andReturn([]);
        $filemaker->shouldReceive('newFindCommand')->once()->andReturn($find);

        $testLayout = new TestLayout();
        $testLayout->setFilemaker($filemaker);

        $this->assertEquals($testLayout->index()->sort('id')->get(), ['data'=>[]]);
    }

    /** @test */
    public function it_fetches_a_list_of_layouts_sorted_desc()
    {
        $filemaker = \Mockery::mock('Filemaker');
        $find = \Mockery::mock('Find');

        $find->shouldReceive('getRange')->andReturn(1);
        $find->shouldReceive('addSortRule');
        $find->shouldReceive('execute')->andReturn($find);
        $find->shouldReceive('getRecords')->andReturn([]);
        $filemaker->shouldReceive('newFindCommand')->once()->andReturn($find);

        $testLayout = new TestLayout();
        $testLayout->setFilemaker($filemaker);

        $this->assertEquals($testLayout->index()->sort('id', 'desc')->get(), ['data'=>[]]);
    }

    /** @test */
    public function it_fetches_a_single_layout()
    {
        $filemaker = \Mockery::mock('Filemaker');
        $find = \Mockery::mock('Find');

        $find->shouldReceive('getRange')->andReturn(1);
        $find->shouldReceive('addFindCriterion');
        $find->shouldReceive('addSortRule');
        $find->shouldReceive('execute')->andReturn($find);
        $find->shouldReceive('getRecords')->andReturn([]);
        $filemaker->shouldReceive('newFindCommand')->once()->andReturn($find);

        $testLayout = new TestLayout();
        $testLayout->setFilemaker($filemaker);

        $this->assertEquals($testLayout->show(1), ['data'=>[]]);
    }

    /** @test */
    public function it_inserts_a_single_record()
    {
        $filemaker = \Mockery::mock('Filemaker');
        $add = \Mockery::mock('Add');

        $add->shouldReceive('execute')->andReturn($add);
        $add->shouldReceive('getRecords')->andReturn([]);
        $filemaker->shouldReceive('newAddCommand')->once()->andReturn($add);

        $testLayout = new TestLayout();
        $testLayout->setFilemaker($filemaker);

        $this->assertEquals($testLayout->create(['id' => 1]), ['data'=>[]]);
    }

    /** @test */
    public function it_tries_to_insert_a_single_record_but_fails_and_catches_invalid_data_exception()
    {
        $filemaker = \Mockery::mock('Filemaker');

        $testLayout = new TestLayout();
        $testLayout->setFilemaker($filemaker);

        $this->expectException(MethodNotAllowed::class);
        $testLayout->create([]);
    }

    /** @test */
    public function it_updates_a_single_layout()
    {
        $filemaker = \Mockery::mock('Filemaker');
        $edit = \Mockery::mock('Edit');

        $edit->shouldReceive('execute')->andReturn($edit);
        $edit->shouldReceive('getRecords')->andReturn([]);
        $filemaker->shouldReceive('newEditCommand')->once()->andReturn($edit);

        $testLayout = new TestLayout();
        $testLayout->setFilemaker($filemaker);

        $this->assertEquals($testLayout->edit(1, ['id' => 1]), ['data'=>[]]);
    }

    /** @test */
    public function it_deletes_a_single_layout()
    {
        $filemaker = \Mockery::mock('Filemaker');
        $delete = \Mockery::mock('Delete');

        $delete->shouldReceive('execute')->andReturn($delete);
        $filemaker->shouldReceive('newDeleteCommand')->once()->andReturn($delete);

        $testLayout = new TestLayout();
        $testLayout->setFilemaker($filemaker);

        $this->assertEquals($testLayout->destroy(1), ['response'=> true]);
    }
}