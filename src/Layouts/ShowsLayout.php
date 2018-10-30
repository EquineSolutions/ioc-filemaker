<?php

namespace EquineSolutions\IOCFilemaker\Layouts;


class ShowsLayout extends Layout
{
    /**
     * returns the name of the layout
     * @return string
     */
    public function getLayout(){
        return 'PHP_SHOW';
    }

    public function getIdFieldName()
    {
        return config('show.id');
    }
}