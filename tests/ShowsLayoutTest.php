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
        $showsLayout = new ShowsLayout();
        // When I run the index method on
        $results = $showsLayout->index();
        // Then I should see
        $this->assertJson(json_encode($results));
    }

    /** @test */
    public function it_fetches_a_single_show()
    {
        $showsLayout = new ShowsLayout();

        $results = $showsLayout->show(1);

        $this->assertArrayHasKey('show_id', $results[0]);
//        $this->assertJson(json_encode($results));
    }

    /** @test */
    public function it_inserts_a_single_show()
    {
        $showLayout = new ShowsLayout();

        $results = $showLayout->create([
            $showLayout->getIdFieldName() => '1001',
            'Show Name' => 'test show'
        ]);

        $this->assertJson(json_encode($results));
    }

    /** @test */
    public function it_updates_a_single_show()
    {
        $showLayout = new ShowsLayout();
        $indexResponse = $showLayout->index();
        $last_record_id = $indexResponse[sizeof($indexResponse)-1]['record_id'];

        $results = $showLayout->update($last_record_id, [
            'Show Name' => 'test show 2'
        ]);

        $this->assertJson(json_encode($results));
    }

    /** @test */
    public function it_deletes_a_single_show()
    {
        $showLayout = new ShowsLayout();
        $indexResponse = $showLayout->index();
        $last_record_id = $indexResponse[sizeof($indexResponse)-1]['record_id'];

        $results = $showLayout->delete($last_record_id);

        $this->assertJson(json_encode($results));
    }
}

