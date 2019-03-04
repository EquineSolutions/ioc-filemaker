<?php

namespace EquineSolutions\IOCFilemaker\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Setup the test case.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Tear down the test case.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * Get the service providers for the package.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            'EquineSolutions\IOCFilemaker\Providers\IOCFilemakerServiceProvider',
        ];
    }

    /**
     * Override this method to set configuration values in your test class
     *
     * @return array of config keys (in dot-notation) and values
     */
    protected function extraConfigs(): array
    {
        return [
            'app.debug' => true,
        ];
    }

    /** @test */
    public abstract function it_fetches_a_single_record_from_filemaker_without_mockery_to_check_fields_names();

    /** @test */
    public abstract function it_inserts_a_single_record();

}
