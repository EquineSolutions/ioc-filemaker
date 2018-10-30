<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 10/21/18
 * Time: 4:03 PM
 */

namespace EquineSolutions\IOCFilemaker\Tests;


use EquineSolutions\IOCFilemaker\Layouts\CompetitionsLayout;

class CompetitionsLayoutTest extends TestCase
{
    /** @test */
    public function it_fetches_a_list_of_competitions()
    {
        $competitionLayout = new CompetitionsLayout();

        $results = $competitionLayout->index();

        $this->assertJson(json_encode($results));
    }

    /** @test */
    public function it_fetches_a_single_competition()
    {
        $competitionLayout = new CompetitionsLayout();

        $results = $competitionLayout->show(1);

        $this->assertJson(json_encode($results));
    }

    /** @test */
    public function it_inserts_a_single_competition()
    {
        $competitionLayout = new CompetitionsLayout();

        $results = $competitionLayout->create([
            $competitionLayout->getIdFieldName() => '10001',
            'Class Name' => 'test competition'
        ]);

        $this->assertJson(json_encode($results));
    }

    /** @test */
    public function it_updates_a_single_competition()
    {
        $competitionLayout = new CompetitionsLayout();
        $indexResponse = $competitionLayout->index();
        $last_record_id = $indexResponse[sizeof($indexResponse)-1]['record_id'];

        $results = $competitionLayout->update($last_record_id, [
            'Class Name' => 'test competition 2'
        ]);

        $this->assertJson(json_encode($results));
    }

    /** @test */
    public function it_deletes_a_single_competition()
    {
        $competitionLayout = new CompetitionsLayout();
        $indexResponse = $competitionLayout->index();
        $last_record_id = $indexResponse[sizeof($indexResponse)-1]['record_id'];

        $results = $competitionLayout->delete($last_record_id);

        $this->assertJson(json_encode($results));
    }
}