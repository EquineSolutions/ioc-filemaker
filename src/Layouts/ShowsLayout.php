<?php

namespace EquineSolutions\IOCFilemaker\Layouts;


class ShowsLayout extends Layout
{
    /**
     * returns the name of the layout
     *
     * @return string
     */
    public function getLayout()
    {
        return 'PHP_SHOW';
    }

    /**
     * returns the field name
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getIdFieldName()
    {
        return config('layouts.show.id');
    }

    /**
     * returns the fields map
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function getFieldsMap()
    {
        return config('layouts.show');
    }
}