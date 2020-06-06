<?php

namespace EquineSolutions\Filemaker\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Setup the test case.
     *
     * @return void
     */
    protected function setUp() :void
    {
        parent::setUp();
    }

    /**
     * Tear down the test case.
     *
     * @return void
     */
    public function tearDown() :void
    {
        parent::tearDown();
    }

}
