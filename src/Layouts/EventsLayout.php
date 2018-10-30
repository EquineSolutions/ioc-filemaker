<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 10/21/18
 * Time: 11:59 AM
 */

namespace EquineSolutions\IOCFilemaker\Layouts;


class EventsLayout extends Layout
{

    /**
     * returns the name of the layout
     * @return string
     */
    public function getLayout()
    {
        return 'PHP_EVENTS';
    }

    public function getIdFieldName()
    {
        return 'event_id';
    }
}