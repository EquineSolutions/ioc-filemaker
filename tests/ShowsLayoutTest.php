<?php

namespace EquineSolutions\IOCFilemaker\Test;


use EquineSolutions\IOCFilemaker\Layouts\ShowsLayout;
use EquineSolutions\IOCFilemaker\Tests\TestCase;

class ShowsLayoutTest extends TestCase
{
    /**
     * The ShowLayout class.
     *
     * @var ShowsLayout
     */
    protected $showLayout;

    /**
     * The fields map.
     *
     * @var array
     */
    protected $fields;

    public function setUp()
    {
        parent::setUp();
        $this->showLayout = new ShowsLayout();
        $this->fields = $this->showLayout->getFieldsMap();
    }

    /** @test */
    public function it_fetches_a_list_of_shows()
    {
        // given
        //

        // When I run the index method on
        $results = $this->showLayout->index()->get();

        // Then I should see
        $this->assertArrayHasKey('data', $results);
        $this->assertArrayHasKey(0, $results['data']);
        foreach ($this->fields as $key => $value)
        {
            $this->assertArrayHasKey($key, $results['data'][0]);
        }
    }

    /** @test */
    public function it_fetches_a_list_of_shows_using_pagination()
    {
        $page = 0;
        do
        {
            $results = $this->showLayout->index()->paginate(5, $page)->get();

            $this->assertArrayHasKey('data', $results);
            $this->assertArrayHasKey('next_page', $results);
            $this->assertArrayHasKey(0, $results['data']);
            foreach ($this->fields as $key => $value)
            {
                $this->assertArrayHasKey($key, $results['data'][0]);
            }
            $page = $results['next_page'];
        }while($page != null);
    }

    /** @test */
    public function it_fetches_a_list_of_shows_using_pagination_using_sort()
    {
        $page = 0;
        do
        {
            $results = $this->showLayout->index()->sort($this->fields['name'])->paginate(5, $page)->get();

            $this->assertArrayHasKey('data', $results);
            $this->assertArrayHasKey('next_page', $results);
            $this->assertArrayHasKey(0, $results['data']);
            foreach ($this->fields as $key => $value)
            {
                $this->assertArrayHasKey($key, $results['data'][0]);
            }
            $page = $results['next_page'];
        }while($page != null);
    }

    /** @test */
    public function it_fetches_a_list_of_shows_with_single_filter()
    {
        $results = $this->showLayout->index()->filter($this->showLayout->getIdFieldName(), '>3')->get();

        $this->assertArrayHasKey('data', $results);
        $this->assertArrayHasKey(0, $results['data']);
        foreach ($this->fields as $key => $value)
        {
            $this->assertArrayHasKey($key, $results['data'][0]);
        }
    }

    /** @test */
    public function it_fetches_a_list_of_shows_with_array_of_filter()
    {
        $last_record = $this->showLayout->index()->sort($this->showLayout->getIdFieldName(), 'desc')->paginate(1)->get();
        $last_id = $last_record['data'][0]['id'];
        $results = $this->showLayout->index()->filter([
            $this->showLayout->getIdFieldName() => $last_id,
        ])->get();

        $this->assertArrayHasKey('data', $results);
        $this->assertArrayHasKey(0, $results['data']);
        foreach ($this->fields as $key => $value)
        {
            $this->assertArrayHasKey($key, $results['data'][0]);
        }
    }

    /** @test */
    public function it_fetches_a_list_of_shows_sorted_asc()
    {
        $results = $this->showLayout->index()->sort($this->showLayout->getIdFieldName())->get();

        $this->assertArrayHasKey('data', $results);
        $this->assertArrayHasKey(0, $results['data']);
        foreach ($this->fields as $key => $value)
        {
            $this->assertArrayHasKey($key, $results['data'][0]);
        }
    }

    /** @test */
    public function it_fetches_a_list_of_shows_sorted_desc()
    {
        $results = $this->showLayout->index()->sort($this->showLayout->getIdFieldName(), 'desc')->get();

        $this->assertArrayHasKey('data', $results);
        $this->assertArrayHasKey(0, $results['data']);
        foreach ($this->fields as $key => $value)
        {
            $this->assertArrayHasKey($key, $results['data'][0]);
        }
    }

    /** @test */
    public function it_fetches_a_single_show()
    {
        $last_record = $this->showLayout->index()->sort($this->showLayout->getIdFieldName(), 'desc')->paginate(1)->get();
        $last_id = $last_record['data'][0]['id'];
        $results = $this->showLayout->show($last_id)->get();

        $this->assertArrayHasKey('data', $results);
        $this->assertArrayHasKey(0, $results['data']);
        foreach ($this->fields as $key => $value)
        {
            $this->assertArrayHasKey($key, $results['data'][0]);
        }
    }

    /** @test */
    public function it_inserts_a_single_show()
    {
        $results = $this->showLayout->create([
            $this->showLayout->getIdFieldName() => '1001',
        ])->post();

        $this->assertArrayHasKey('data', $results);
        $this->assertArrayHasKey(0, $results['data']);

        foreach ($this->fields as $key => $value)
        {
            $this->assertArrayHasKey($key, $results['data'][0]);
        }
    }

    /** @test */
    public function it_updates_a_single_show()
    {
        $last_record = $this->showLayout->show(1001)->get();
        $last_record_id = $last_record['data'][0]['record_id'];
        $results = $this->showLayout->edit($last_record_id, [
            $this->showLayout->getIdFieldName() => '1001',
        ])->update();

        $this->assertArrayHasKey('data', $results);
        $this->assertArrayHasKey(0, $results['data']);

        foreach ($this->fields as $key => $value)
        {
            $this->assertArrayHasKey($key, $results['data'][0]);
        }
    }

    /** @test */
    public function it_deletes_a_single_show()
    {
        $last_record = $this->showLayout->show(1001)->get();
        $last_record_id = $last_record['data'][0]['record_id'];
        $results = $this->showLayout->destroy($last_record_id)->delete();

        $this->assertArrayHasKey('response', $results);
        $this->assertTrue($results['response']);
    }
}

