<?php

namespace EquineSolutions\IOCFilemaker\Traits;

use airmoi\FileMaker\FileMakerException;
use airmoi\FileMaker\Object\Record;
use EquineSolutions\IOCFilemaker\Exceptions\FieldDoesNotExist;

trait ConvertToArray
{
    /**
     * converts filemaker result object to mapped array
     *
     * @param $result
     * @return array
     * @throws FieldDoesNotExist
     * @throws FileMakerException
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
     * @throws FileMakerException
     */
    protected function mapSingle(Record $record)
    {
        $fields = $this->getFieldsMap();
        $converted_object = array();

        $filemaker_fields = $record->getFields();

        foreach ($fields as $key => $value)
        {
            if(!in_array($value, $filemaker_fields)){
                throw (new FieldDoesNotExist("$value Field Doesn't Exist"));
            }

            $temp_field = strtolower($value);
            if (((string)strpos($temp_field, 'file')) >='0') {
                $full_path = $this->getFilemaker()->getContainerDataURL($record->getField($value));
                if ($full_path != ''){
                    $converted_object[$key] =  'http://' . $full_path;
                }
                else{
                    $converted_object[$key] = '';
                }
            } else {
                $converted_object[$key] = $record->getField($value);
            }
        }
        return $converted_object;
    }

}