<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 10/21/18
 * Time: 4:01 PM
 */

namespace EquineSolutions\IOCFilemaker\Layouts;


class CompetitionsLayout extends Layout
{

    /**
     * returns the name of the layout
     * @return string
     */
    public function getLayout()
    {
        return 'PHP_CLASSES';
    }

    public function getIdFieldName()
    {
        return "class_id";
    }
}