<?php
/**
 * Remove those useless comments
 *
 * Created by PhpStorm.
 * User: mac
 * Date: 10/20/18
 * Time: 2:01 PM
 */

namespace EquineSolutions\IOCFilemaker;

use \airmoi\FileMaker\FileMaker;
use airmoi\FileMaker\FileMakerException;

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
     *
     * @param $database_name
     * @throws FileMakerException
     */
    public function __construct($database_name)
    {
        // You should read the config from a config file and not
        // from the env file directly as best practice

        $this->filemaker = new FileMaker(
            $database_name,
            env('FILEMAKER_HOSTSPEC'),
            env('FILEMAKER_USERNAME'),
            env('FILEMAKER_PASSWORD')
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