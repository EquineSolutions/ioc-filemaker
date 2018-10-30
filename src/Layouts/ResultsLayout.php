<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 10/21/18
 * Time: 4:06 PM
 */

namespace EquineSolutions\IOCFilemaker\Layouts;


class ResultsLayout extends Layout
{

    /**
     * returns the name of the layout
     * @return string
     */
    public function getLayout()
    {
        return 'PHP_RESULTS';
    }

    public function getIdFieldName()
    {
        return "masterresult_id";
    }
}