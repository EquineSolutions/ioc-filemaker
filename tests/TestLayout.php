<?php

namespace EquineSolutions\Filemaker\Tests;

use EquineSolutions\Filemaker\Exceptions\MethodNotAllowed;
use EquineSolutions\Filemaker\Layouts\Layout;

class TestLayout extends Layout
{
    /**
     * returns the name of the layout
     *
     * @return string
     */
    protected function getLayout() :string
    {
        return "test";
    }

    /**
     * returns the field name
     *
     * @return string
     */
    public function getIdKeyName() :string
    {
        return 'id';
    }

    /**
     * returns the fields map
     *
     * @return array
     */
    public function getFieldsMap() :array
    {
        return [
            'id' => 'id'
        ];
    }

    /**
     * validates the data passed to create method matches filemaker conditions
     *
     * @param $data
     * @throws MethodNotAllowed
     * @return boolean
     */
    public function validateData(array $data)
    {
        if(array_key_exists('id', $data)){
            return true;
        }
        throw new MethodNotAllowed();
    }

    /**
     * @inheritDoc
     */
    public function getDatabaseName() :string
    {
        return "";
    }

    /**
     * @inheritDoc
     */
    public function getHost(): string
    {
        return "";
    }

    /**
     * @inheritDoc
     */
    public function getUsername(): string
    {
        return "";
    }

    /**
     * @inheritDoc
     */
    public function getPassword(): string
    {
        return "";
    }

    /**
     * @inheritDoc
     */
    public function validateUpdateData(array $data)
    {
        if(array_key_exists('id', $data)){
            return true;
        }
        throw new MethodNotAllowed();
    }
}