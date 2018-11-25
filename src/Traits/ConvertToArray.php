<?php

namespace EquineSolutions\IOCFilemaker\Traits;

trait ConvertToArray
{
    /**
     * converts filemaker result object to mapped array
     *
     * @param $result
     * @return array
     */
    private function convertToArray($result)
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
     * @param $record
     * @return array
     */
    private function mapSingle($record)
    {
        //TODO handle if the incoming field is image to be downloaded with getContainerDataURL
        $fields = $this->getFieldsMap();
        $converted_object = array();
        foreach ($fields as $key => $value)
        {
            $converted_object[$key] = $record->getField($value);
        }
        return $converted_object;
    }

}