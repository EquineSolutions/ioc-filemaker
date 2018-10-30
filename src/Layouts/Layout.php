<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 10/20/18
 * Time: 4:39 PM
 */

namespace EquineSolutions\IOCFilemaker\Layouts;


use EquineSolutions\IOCFilemaker\ArrayConverter;
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
        return (new ArrayConverter())->toArray($filemaker->newFindCommand($this->getLayout())
            ->execute()
            ->getRecords(), $filemaker);
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
        return (new ArrayConverter())->toArray($filemaker->newFindCommand($this->getLayout())
            ->addFindCriterion($this->getIdFieldName(), '='.$id)
            ->execute()
            ->getRecords(), $filemaker);
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
        return (new ArrayConverter())->toArray($filemaker->newAddCommand($this->getLayout(), $data)
            ->execute()
            ->getRecords(), $filemaker);
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
        return (new ArrayConverter())->toArray($filemaker->newEditCommand($this->getLayout(), $record_id, $data)
            ->execute()
            ->getRecords(), $filemaker);
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
        return (new ArrayConverter())->toArray($filemaker->newDeleteCommand($this->getLayout(), $record_id)
            ->execute()
            ->getRecords(), $filemaker);
    }
}








