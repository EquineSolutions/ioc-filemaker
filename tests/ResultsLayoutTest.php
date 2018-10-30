<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 10/21/18
 * Time: 4:21 PM
 */

namespace EquineSolutions\IOCFilemaker\Tests;


use EquineSolutions\IOCFilemaker\Layouts\ResultsLayout;

class ResultsLayoutTest extends TestCase
{
    /** @test */
    public function it_fetches_a_list_of_results()
    {
        $resultLayout = new ResultsLayout();

        $results = $resultLayout->index();

        $this->assertJson(json_encode($results));
    }

    /** @test */
    public function it_fetches_a_single_result()
    {
        $resultLayout = new ResultsLayout();

        $results = $resultLayout->show(1);

        $this->assertJson(json_encode($results));
    }

    /** @test */
    public function it_inserts_a_single_result()
    {
        $resultLayout = new ResultsLayout();

        $results = $resultLayout->create([
            $resultLayout->getIdFieldName() => '20001',
            'Order' => '1'
        ]);

        $this->assertJson(json_encode($results));
    }

    /** @test */
    public function it_updates_a_single_result()
    {
        $resultLayout = new ResultsLayout();
        $indexResponse = $resultLayout->index();
        $last_record_id = $indexResponse[sizeof($indexResponse)-1]['record_id'];

        $results = $resultLayout->update($last_record_id, [
            'Order' => '2'
        ]);

        $this->assertJson(json_encode($results));
    }

    /** @test */
    public function it_deletes_a_single_result()
    {
        $resultLayout = new ResultsLayout();
        $indexResponse = $resultLayout->index();
        $last_record_id = $indexResponse[sizeof($indexResponse)-1]['record_id'];

        $results = $resultLayout->delete($last_record_id);

        $this->assertJson(json_encode($results));
    }
}