<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 10/20/18
 * Time: 4:39 PM
 */

namespace EquineSolutions\IOCFilemaker\Layouts;


use EquineSolutions\IOCFilemaker\FilemakerResultConverter;
use EquineSolutions\IOCFilemaker\Connector;

abstract class Layout
{
    /**
     * returns the name of the layout
     * @return string
     */
    public abstract function getLayout();

    public abstract function getIdFieldName();

    /**
     * returns list of the resource
     * @return array
     * @throws \airmoi\FileMaker\FileMakerException
     */
    public function index()
    {
        $filemaker = (new Connector())->filemaker();
        return (new FilemakerResultConverter(
            $filemaker->newFindCommand($this->getLayout())
                ->execute()
                ->getRecords()
        ))->toArray();
    }

    /**
     * returns specified resource
     * @param $field_name
     * @param $id
     * @return array
     * @throws \airmoi\FileMaker\FileMakerException
     */
    public function show($id)
    {
        $filemaker = (new Connector())->filemaker();
        return (new FilemakerResultConverter(
            $filemaker->newFindCommand($this->getLayout())
            ->addFindCriterion($this->getIdFieldName(), '='.$id)
            ->execute()
            ->getRecords()
        ))->toArray();
    }

    /**
     * creates new resources with given data
     * @param $data
     * @return array
     * @throws \airmoi\FileMaker\FileMakerException
     * @throws \airmoi\FileMaker\FileMakerValidationException
     */
    public function create($data)
    {
        $filemaker = (new Connector())->filemaker();
        return (new FilemakerResultConverter(
            $filemaker->newAddCommand($this->getLayout(), $data)
            ->execute()
            ->getRecords()
        ))->toArray();
    }

    /**
     * updates resource with record id specified
     * @param $record_id
     * @param $data
     * @return array
     * @throws \airmoi\FileMaker\FileMakerException
     * @throws \airmoi\FileMaker\FileMakerValidationException
     */
    public function update($record_id, $data)
    {
        $filemaker = (new Connector())->filemaker();
        return (new FilemakerResultConverter(
            $filemaker->newEditCommand($this->getLayout(), $record_id, $data)
                ->execute()
                ->getRecords()
        ))->toArray();
    }

    /**
     * deletes resource with record id specified
     * @param $record_id
     * @return array
     * @throws \airmoi\FileMaker\FileMakerException
     */
    public function delete($record_id)
    {
        $filemaker = (new Connector())->filemaker();
        return (new FilemakerResultConverter(
            $filemaker->newDeleteCommand($this->getLayout(), $record_id)
            ->execute()
            ->getRecords()
        ))->toArray();
    }
}








