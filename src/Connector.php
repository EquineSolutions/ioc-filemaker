<?php

namespace EquineSolutions\Filemaker;

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
     * @param $databaseName
     * @throws FileMakerException
     */
    public function __construct($databaseName)
    {
        $this->filemaker = new FileMaker(
            $databaseName,
            config('filemaker.host'),
            config('filemaker.username'),
            config('filemaker.password'),
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