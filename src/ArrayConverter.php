<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 10/22/18
 * Time: 1:21 PM
 */

namespace EquineSolutions\IOCFilemaker;

use \airmoi\FileMaker\FileMaker;

class ArrayConverter
{
    public function toArray($filemakerResponse, FileMaker $filemaker)
    {
        $translatedArray = array();
        foreach ($filemakerResponse as $singleRecord) {
            array_push($translatedArray, $this->convertSingle($singleRecord, $filemaker));
        }
        return $translatedArray;
    }

    private function convertSingle($record, FileMaker $filemaker)
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