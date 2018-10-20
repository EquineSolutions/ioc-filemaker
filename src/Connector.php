<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 10/20/18
 * Time: 2:01 PM
 */

namespace EquineSolutions\IOCFilemaker;
use \airmoi\FileMaker\FileMaker;

class Connector
{
    /**
     * The filemaker class.
     *
     * @var FileMaker
     */
    private $filemaker;

    /**
     * Connector Construct.
     * @param $database_name
     */
    public function __construct($database_name = 'ioc-database')
    {
        $this->filemaker = new FileMaker(
            config("ioc-filemaker.$database_name"),
            config('ioc-filemaker.hostspec'),
            config('ioc-filemaker.username'),
            config('ioc-filemaker.password')
        );
    }

    /**
     * Fetch the filemaker object,
     *
     * @return FileMaker
     */
    public function filemaker()
    {
        return $this->filemaker;
    }
}