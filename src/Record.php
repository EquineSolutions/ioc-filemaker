<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 10/30/18
 * Time: 12:09 PM
 */

namespace EquineSolutions\IOCFilemaker;

use \airmoi\FileMaker\Object\Record as FilemakerRecord;

class Record extends FilemakerRecord
{
    public function __toArray()
    {
        $fields = $this->fields;
        $temp = array();
        foreach ($fields as $field) {
            $temp[$field] = $this->getField($field);
        }
        return $temp;
    }
}