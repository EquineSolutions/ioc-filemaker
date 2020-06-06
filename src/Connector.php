<?php

namespace EquineSolutions\Filemaker;

use \airmoi\FileMaker\FileMaker;
use airmoi\FileMaker\FileMakerException;

class Connector
{
    /**
     * The filemaker host server.
     *
     * @var string
     */
    private $host;

    /**
     * The filemaker username.
     *
     * @var string
     */
    private $username;

    /**
     * The filemaker password.
     *
     * @var string
     */
    private $password;

    /**
     * The filemaker database.
     *
     * @var string
     */
    private $database_name;

    /**
     * Connector constructor.
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database_name
     */
    public function __construct(string $host = "", string $username = "", string $password = "", string $database_name = "")
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database_name = $database_name;
    }

    /**
     * Fetch the filemaker object,
     *
     * @return FileMaker
     * @throws FileMakerException
     */
    public function filemaker()
    {
        return new FileMaker(
            $this->database_name,
            $this->host,
            $this->username,
            $this->password,
        );
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string $database_name
     */
    public function setDatabaseName(string $database_name): void
    {
        $this->database_name = $database_name;
    }
}