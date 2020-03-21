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
        // type hint the results data and I think returning a laravel
        // collection is a better choice

        $converted_array = array();
        foreach ($result as $single_record)
        {
            array_push($converted_array, $this->mapSingle($single_record));
        }

        return $converted_array;
    }

    /**
     * Maps single filemaker object to array
     *
     * @param Record $record
     * @return array
     * @throws FieldDoesNotExist
     * @throws FileMakerException
     */
    protected function mapSingle(Record $record)
    {
        // Again type hint the returned type.
        // As php and laravel best practice variable names should be in
        // camelCase instead of snake_case

        $fields = $this->getFieldsMap();
        $converted_object = array();

        $filemaker_fields = $record->getFields();

        foreach ($fields as $key => $value)
        {
            if(!in_array($value, $filemaker_fields)){
                throw (new FieldDoesNotExist("$value Field Doesn't Exist"));
            }

            $temp_field = strtolower($value);
            // What is going on here you need to make this more clear and readable.
            if (((string) strpos($temp_field, 'file')) >='0') {
                // also looks like this trait is specific to a class that has the method getFilemaker()
                // this needs to be refactored to something more generic. or pass the file maker object to the method
                // this is now very tightly coupled with what ever class that is going to use this
                // unless there is an interface that i don't know about.
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