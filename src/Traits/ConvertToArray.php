<?php

namespace EquineSolutions\Filemaker\Traits;

use airmoi\FileMaker\FileMaker;
use airmoi\FileMaker\FileMakerException;
use airmoi\FileMaker\Object\Record;
use EquineSolutions\Filemaker\Exceptions\FieldDoesNotExist;

trait ConvertToArray
{
    /**
     * converts filemaker result object to mapped array
     *
     * @param FileMaker $filemaker
     * @param $result
     * @return array
     * @throws FieldDoesNotExist
     * @throws FileMakerException
     */
    protected function convertToArray($filemaker, $result)
    {
        $convertedArray = array();
        foreach ($result as $single_record)
        {
            array_push($convertedArray, $this->mapSingle($filemaker, $single_record));
        }

        return $convertedArray;
    }

    /**
     * Maps single filemaker object to array
     *
     * @param FileMaker $fileMaker
     * @param Record $record
     * @return array
     * @throws FieldDoesNotExist
     * @throws FileMakerException
     */
    protected function mapSingle($fileMaker, Record $record)
    {
        $fields = $this->getFieldsMap();
        $convertedObject = array();

        $filemakerFields = $record->getFields();

        foreach ($fields as $key => $value)
        {
            if(!in_array($value, $filemakerFields)){
                throw (new FieldDoesNotExist("$value Field Doesn't Exist"));
            }

            // For a file to be sent from the filemaker it is put in a container
            // in order for me to know that it is a file that it contains a file string in the field name
            // so I can get the container url
            if (((string) strpos($key, 'file')) >='0') {
                $fullPath = $fileMaker->getContainerDataURL($record->getField($value));
                if ($fullPath != ''){
                    $convertedObject[$key] =  'http://' . $fullPath;
                }
                else{
                    $convertedObject[$key] = '';
                }
            } else {
                $convertedObject[$key] = trim($record->getField($value));
            }
        }
        return $convertedObject;
    }

}