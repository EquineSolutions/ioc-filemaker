<?php

namespace EquineSolutions\IOCFilemaker\Layouts;


use EquineSolutions\IOCFilemaker\Exceptions\MethodNotAllowed;

class Show extends Layout
{
    /**
     * returns the name of the layout
     *
     * @return string
     */
    public function getLayout()
    {
        return 'PHP_SHOW';
    }

    /**
     * returns the field name
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getIdFieldName()
    {
        return config('layouts.show.id');
    }

    /**
     * returns the fields map
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getFieldsMap()
    {
        return config('layouts.show');
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
        return true;
    }

    /**
     * @return array|void
     * @throws MethodNotAllowed
     */
    public function post()
    {
        throw new MethodNotAllowed;
    }

    /**
     * @param $record_id
     * @param $data
     * @return Layout|void
     * @throws MethodNotAllowed
     */
    public function edit($record_id, $data)
    {
        throw new MethodNotAllowed;
    }

    /**
     * @param $record_id
     * @return Layout|void
     * @throws MethodNotAllowed
     */
    public function destroy($record_id)
    {
        throw new MethodNotAllowed;
    }
}