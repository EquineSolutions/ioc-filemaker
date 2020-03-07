<?php
/**
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
     * @param $database_name
     * @throws FileMakerException
     */
    public function __construct($database_name)
    {
        $this->filemaker = new FileMaker(
            $database_name,
            config('filemaker.hostspec'),
            config('filemaker.username'),
            config('filemaker.password')
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