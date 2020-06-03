<?php

namespace EquineSolutions\Filemaker\Tests;

use EquineSolutions\Filemaker\Exceptions\MethodNotAllowed;
use EquineSolutions\Filemaker\Layouts\Layout;

class LevelLayout extends Layout
{
    /**
     * returns the name of the layout
     *
     * @return string
     */
    protected function getLayout() :string
    {
        return "levels";
    }

    /**
     * returns the field name
     *
     * @return string
     */
    public function getIdKeyName() :string
    {
        return 'level_id';
    }

    /**
     * returns the fields map
     *
     * @return array
     */
    public function getFieldsMap() :array
    {
        return [
            'id' => 'level_id',
            'name' => 'Leve Name',
            'age_from' => 'age from',
            'age_to' => 'age to',
            'filemaker_timestamp' => 'Modification'
        ];
    }

    /**
     * validates the data passed to create method matches filemaker conditions
     *
     * @param array $data
     * @return void
     * @throws MethodNotAllowed
     */
    public function validateData(array $data)
    {
        throw new MethodNotAllowed();
    }

    /**
     * @inheritDoc
     */
    public function validateUpdateData(array $data)
    {
        throw new MethodNotAllowed();
    }

    /**
     * @inheritDoc
     */
    public function getDatabaseName() :string
    {
        return "G7";
    }

    /**
     * @inheritDoc
     */
    public function getHost(): string
    {
        return "n471.fmphost.com";
    }

    /**
     * @inheritDoc
     */
    public function getUsername(): string
    {
        return "Admin";
    }

    /**
     * @inheritDoc
     */
    public function getPassword(): string
    {
        return "P@ssw0rd9666";
    }
}