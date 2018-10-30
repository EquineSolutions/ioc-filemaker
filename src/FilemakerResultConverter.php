<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 10/22/18
 * Time: 1:21 PM
 */

namespace EquineSolutions\IOCFilemaker;

class FilemakerResultConverter
{
    private $results;

    public function __construct($results)
    {
        $this->results = $results;
    }

    public function toArray()
    {
        $translatedArray = array();
        foreach ($this->results as $singleRecord) {
            array_push($translatedArray, $this->convertSingle($singleRecord));
        }
        return $translatedArray;
    }

    private function convertSingle($record)
    {
        //TODO handle if the incoming field is image to be downloaded with getContainerDataURL
        $fields = $record->getFields();
        $temp = array();
        foreach ($fields as $field) {
            $temp[$field] = $record->getField($field);
        }
        return $temp;
    }
}