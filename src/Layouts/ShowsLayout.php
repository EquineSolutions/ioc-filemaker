<?php

namespace EquineSolutions\IOCFilemaker\Layouts;

class ShowsLayout
{
    public function __construct()
    {
        $this->layoutName = '';
    }

    public function index()
    {
        return [
            'data' => [
                'show_name' => 'abdo',
            ]
        ];
    }
}