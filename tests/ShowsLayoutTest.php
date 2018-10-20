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
        $this->assertArraySubset($results, [
            'data' => [
                'show_name' => 'abdo',
            ]
        ]);
    }
}