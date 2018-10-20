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
//        $this->assertTrue(true);
        $this->assertArrayHasKey(0, $results);
    }

    /** @test */
    public function it_fetches_a_single_show()
    {
        $showsLayout = new ShowsLayout();

        $result = $showsLayout->show(1);

        $this->assertArraySubset($result,
            Array(
                0 => Array(
                    'show_id' => '1',
                    'Show Name' => 'The Gulf Elite Tour',
                    'Date From' => '01/25/2018',
                    'Date To' => '01/27/2018',
                    'Year' => '2018',
                    'Location' => 'Sharjah Equestrain Club',
                    'Country' => 'UAE',
                    'Organizer Name' => 'Shk. Ali Al Qassmi',
                    'Organizer Contact' => '',
                    'Organizer Address' => 'Sharjah Club',
                    'Show Prize Money' => '',
                    'Number Of Events' => '1',
                    'Horse Per Show' => '3',
                    'LOGO' => 'http://n411.fmphost.com/fmi/xml/cnt/AAAAA_logo_.jpg?-db=IOCT&-lay=PHP_SHOW&-recid=75&-field=LOGO(1)',
                    'ksponsor1logo' => '',
                    'ksponsor2logo' => '',
                    'ksponsor3logo' => '',
                    'ksponsor4logo' => '',
                    'ksponsor5logo' => '',
                    'ksponsor6logo' => '',
                    'Currency' => 'AED',
                    '' => '',
                    'modification timestamp' => '10/12/2018 16:47:13',
                    'FEI_Prog' => 'https://data.fei.org/Calendar/DraftSchedulePush.aspx?p=866188174EE9B18C2858B0D6054573BC6CE4C4A1E875EDAFD51DF5E8777D7D150A61709D0F8E804F8D1AB4B9C50F600132F53EA5C44ADCF2B176F5ECD53D9D90010A5A85C18F284DAF1585FCFDB4E6E27A0B45F98D78E3DFCAB1989CC4FFD6AD8A6AABF27E1F9CD29706158DAAB7D7D98D62284FD90A343D6CE6083EED4D40E4C6FF8DA680ABC0A99105D90E3E3095CE4E1354866FC45C613689C901437818A3',
                    'record_id' => '75',
                )
            )
         );
    }

    /** @test */
    public function it_inserts_a_single_show()
    {
        $showLayout = new ShowsLayout();

        $result = $showLayout->create([
            'show_id' => '1001',
            'Show Name' => 'test show'
        ]);

        $this->assertArrayHasKey(0, $result);
    }

    /** @test */
    public function it_updates_a_single_show()
    {
        $showLayout = new ShowsLayout();
        $indexResponse = $showLayout->index();
        $last_record_id = $indexResponse[sizeof($indexResponse)-1]['record_id'];

        $result = $showLayout->update($last_record_id, [
            'Show Name' => 'test show 2'
        ]);

        $this->assertArrayHasKey(0, $result);
    }

    /** @test */
    public function it_deletes_a_single_show()
    {
        $showLayout = new ShowsLayout();
        $indexResponse = $showLayout->index();
        $last_record_id = $indexResponse[sizeof($indexResponse)-1]['record_id'];
        $result = $showLayout->delete($last_record_id);

        $this->assertArraySubset($result, []);
    }
}

