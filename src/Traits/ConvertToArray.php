<?php

namespace EquineSolutions\IOCFilemaker\Traits;

use airmoi\FileMaker\Object\Record;
use EquineSolutions\IOCFilemaker\Exceptions\FieldDoesNotExist;
use function PHPSTORM_META\type;

trait ConvertToArray
{
    /**
     * converts filemaker result object to mapped array
     *
     * @param $result
     * @return array
     * @throws FieldDoesNotExist
     * @throws \airmoi\FileMaker\FileMakerException
     */
    protected function convertToArray($result)
    {
        $converted_array = array();
        foreach ($result as $single_record)
        {
            array_push($converted_array, $this->mapSingle($single_record));
        }
        return $converted_array;
    }

    /**
     * maps single filemaker object to array
     *
     * @param Record $record
     * @return array
     * @throws FieldDoesNotExist
     * @throws \airmoi\FileMaker\FileMakerException
     */
    protected function mapSingle(Record $record)
    {
        //TODO handle if the incoming field is image to be downloaded with getContainerDataURL
        $fields = $this->getFieldsMap();
        $converted_object = array();

        $filemaker_fields = $record->getFields();

        foreach ($fields as $key => $value)
        {
            if(!in_array($value, $filemaker_fields)){
                throw (new FieldDoesNotExist("$value Field Doesn't Exist"));
            }
            $converted_object[$key] = $record->getField($value);
        }
        return $converted_object;
    }

}