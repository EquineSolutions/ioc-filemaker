<?php

namespace EquineSolutions\IOCFilemaker\Traits;

use airmoi\FileMaker\FileMaker;

trait Sort
{
    /**
     * add sorting rule asc or desc
     *
     * @param $key
     * @param $order
     * @return $this
     */
    public function sort($key, $order = 'asc')
    {
        $order = $order == 'desc'? FileMaker::SORT_DESCEND:FileMaker::SORT_ASCEND;
        $this->sort_rule = [$key => $order];
        return $this;
    }

    /**
     * apply sort rule
     */
    public function applySort()
    {
        $this->command->addSortRule(key($this->sort_rule), 1, current($this->sort_rule));
    }
}