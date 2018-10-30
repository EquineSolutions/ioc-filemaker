<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 10/21/18
 * Time: 12:01 PM
 */

namespace EquineSolutions\IOCFilemaker\Tests;


use EquineSolutions\IOCFilemaker\Layouts\EventsLayout;

class EventsLayoutTest extends TestCase
{
    /** @test */
    public function it_fetches_a_list_of_events()
    {
        $eventLayout = new EventsLayout();

        $results = $eventLayout->index();

        $this->assertJson(json_encode($results));
    }

    /** @test */
    public function it_fetches_a_single_event()
    {
        $eventLayout = new EventsLayout();

        $results = $eventLayout->show(1);

        $this->assertJson(json_encode($results));
    }

    /** @test */
    public function it_inserts_a_single_event()
    {
        $eventLayout = new EventsLayout();

        $results = $eventLayout->create([
            $eventLayout->getIdFieldName() => '1001',
            'Event Name' => 'test event',
            'show_id_match' => 1
        ]);

        $this->assertJson(json_encode($results));
    }

    /** @test */
    public function it_updates_a_single_event()
    {
        $eventLayout = new EventsLayout();
        $indexResponse = $eventLayout->index();
        $last_record_id = $indexResponse[sizeof($indexResponse)-1]['record_id'];

        $results = $eventLayout->update($last_record_id, [
            'Event Name' => 'test event 2'
        ]);

        $this->assertJson(json_encode($results));
    }

    /** @test */
    public function it_deletes_a_single_event()
    {
        $eventLayout = new EventsLayout();
        $indexResponse = $eventLayout->index();
        $last_record_id = $indexResponse[sizeof($indexResponse)-1]['record_id'];

        $results = $eventLayout->delete($last_record_id);

        $this->assertJson(json_encode($results));
    }
}