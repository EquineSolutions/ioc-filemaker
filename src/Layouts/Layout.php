<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 10/20/18
 * Time: 4:39 PM
 */

namespace EquineSolutions\IOCFilemaker\Layouts;


interface Layout
{
    /**
     * returns the name of the layout
     * @return string
     */
    public function getLayout();

    /**
     * returns list of the resource
     * @return array
     */
    public function index();

    /**
     * returns specified resource
     * @param $id
     * @return array
     */
    public function show($id);

    /**
     * creates new resources with given data
     * @param $data
     * @return array
     */
    public function create($data);

    /**
     * updates resource with record id specified
     * @param $record_id
     * @param $data
     * @return array
     */
    public function update($record_id, $data);

    /**
     * deletes resource with record id specified
     * @param $record_id
     * @return array
     */
    public function delete($record_id);
}