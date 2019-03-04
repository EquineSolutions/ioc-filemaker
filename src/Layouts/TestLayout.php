<?php

namespace EquineSolutions\IOCFilemaker\Layouts;


use EquineSolutions\IOCFilemaker\Exceptions\MethodNotAllowed;

class TestLayout extends Layout
{
    /**
     * returns the name of the layout
     *
     * @return string
     */
    protected function getLayout()
    {
        return "test";
    }

    /**
     * returns the field name
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getIdFieldName()
    {
        return 'id';
    }

    /**
     * returns the fields map
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getFieldsMap()
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
}