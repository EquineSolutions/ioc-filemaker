<?php

namespace EquineSolutions\IOCFilemaker\Test;


use EquineSolutions\IOCFilemaker\Layouts\ShowsLayout;
use EquineSolutions\IOCFilemaker\Tests\TestCase;

class ShowsLayoutTest extends TestCase
{
    /** @test */
    public function it_fetches_a_list_of_shows()
    {
        // given
        //
        $showLayout = new ShowsLayout();
        $fields = $showLayout->getFieldsMap();

        // When I run the index method on
        $results = $showLayout->index()->get();

        // Then I should see
        $this->assertArrayHasKey('data', $results);
        $this->assertArrayHasKey(0, $results['data']);
        foreach ($fields as $key => $value)
        {
            $this->assertArrayHasKey($key, $results['data'][0]);
        }
    }

    /** @test */
    public function it_fetches_a_list_of_shows_using_pagination()
    {
        $showLayout = new ShowsLayout();
        $fields = $showLayout->getFieldsMap();
        $page = 0;
        do
        {
            $results = $showLayout->index()->paginate(5, $page)->get();

            $this->assertArrayHasKey('data', $results);
            $this->assertArrayHasKey('next_page', $results);
            $this->assertArrayHasKey(0, $results['data']);
            foreach ($fields as $key => $value)
            {
                $this->assertArrayHasKey($key, $results['data'][0]);
            }
            $page = $results['next_page'];
        }while($page != null);
    }

    /** @test */
    public function it_fetches_a_list_of_shows_with_single_filter()
    {
        $showLayout = new ShowsLayout();
        $fields = $showLayout->getFieldsMap();

        $results = $showLayout->index()->filter($showLayout->getIdFieldName(), '>3')->get();

        $this->assertArrayHasKey('data', $results);
        $this->assertArrayHasKey(0, $results['data']);
        foreach ($fields as $key => $value)
        {
            $this->assertArrayHasKey($key, $results['data'][0]);
        }
    }

    /** @test */
    public function it_fetches_a_list_of_shows_with_array_of_filter()
    {
        $showLayout = new ShowsLayout();
        $fields = $showLayout->getFieldsMap();

        $last_record = $showLayout->index()->sort($showLayout->getIdFieldName(), 'desc')->paginate(1)->get();
        $last_id = $last_record['data'][0]['id'];
        $results = $showLayout->index()->filter([
            $showLayout->getIdFieldName() => $last_id,
        ])->get();

        $this->assertArrayHasKey('data', $results);
        $this->assertArrayHasKey(0, $results['data']);
        foreach ($fields as $key => $value)
        {
            $this->assertArrayHasKey($key, $results['data'][0]);
        }
    }

    /** @test */
    public function it_fetches_a_list_of_shows_sorted_asc()
    {
        $showLayout = new ShowsLayout();
        $fields = $showLayout->getFieldsMap();

        $results = $showLayout->index()->sort($showLayout->getIdFieldName())->get();

        $this->assertArrayHasKey('data', $results);
        $this->assertArrayHasKey(0, $results['data']);
        foreach ($fields as $key => $value)
        {
            $this->assertArrayHasKey($key, $results['data'][0]);
        }
    }

    /** @test */
    public function it_fetches_a_list_of_shows_sorted_desc()
    {
        $showLayout = new ShowsLayout();
        $fields = $showLayout->getFieldsMap();

        $results = $showLayout->index()->sort($showLayout->getIdFieldName(), 'desc')->get();

        $this->assertArrayHasKey('data', $results);
        $this->assertArrayHasKey(0, $results['data']);
        foreach ($fields as $key => $value)
        {
            $this->assertArrayHasKey($key, $results['data'][0]);
        }
    }

    /** @test */
    public function it_fetches_a_single_show()
    {
        $showLayout = new ShowsLayout();
        $fields = $showLayout->getFieldsMap();

        $last_record = $showLayout->index()->sort($showLayout->getIdFieldName(), 'desc')->paginate(1)->get();
        $last_id = $last_record['data'][0]['id'];
        $results = $showLayout->show($last_id)->get();

        $this->assertArrayHasKey('data', $results);
        $this->assertArrayHasKey(0, $results['data']);
        foreach ($fields as $key => $value)
        {
            $this->assertArrayHasKey($key, $results['data'][0]);
        }
    }

    /** @test */
    public function it_inserts_a_single_show()
    {
        $showLayout = new ShowsLayout();
        $fields = $showLayout->getFieldsMap();

        $results = $showLayout->create([
            $showLayout->getIdFieldName() => '1001',
        ])->post();

        $this->assertArrayHasKey('data', $results);
        $this->assertArrayHasKey(0, $results['data']);

        foreach ($fields as $key => $value)
        {
            $this->assertArrayHasKey($key, $results['data'][0]);
        }
    }

    /** @test */
    public function it_updates_a_single_show()
    {
        $showLayout = new ShowsLayout();
        $fields = $showLayout->getFieldsMap();

        $last_record = $showLayout->show(1001)->get();
        $last_record_id = $last_record['data'][0]['record_id'];
        $results = $showLayout->edit($last_record_id, [
            $showLayout->getIdFieldName() => '1002',
        ])->update();

        $this->assertArrayHasKey('data', $results);
        $this->assertArrayHasKey(0, $results['data']);

        foreach ($fields as $key => $value)
        {
            $this->assertArrayHasKey($key, $results['data'][0]);
        }
    }

    /** @test */
    public function it_deletes_a_single_show()
    {
        $showLayout = new ShowsLayout();

        $last_record = $showLayout->show(1001)->get();
        $last_record_id = $last_record['data'][0]['record_id'];
        $results = $showLayout->destroy($last_record_id)->delete();

        $this->assertArrayHasKey('response', $results);
        $this->assertTrue($results['response']);
    }
}

