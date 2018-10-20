<?php

use \airmoi\FileMaker\FileMaker;

if (!function_exists('translateALl')) {
    function translateALl($filemakerResponse, FileMaker $filemaker)
    {
        $translatedArray = array();
        foreach ($filemakerResponse as $singleRecord) {
            array_push($translatedArray, translateSingle($singleRecord, $filemaker));
        }
        return $translatedArray;
    }
}

if (!function_exists('translateSingle')) {
    function translateSingle($record, FileMaker $filemaker)
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