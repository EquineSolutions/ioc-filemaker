<?php

namespace EquineSolutions\IOCFilemaker\Traits;

trait Filter
{
    /**
     * adds filters to the query
     *
     * @param $filters
     * @param null $value
     * @return $this
     */
    public function filter($filters, $value = null)
    {
        if (is_string($filters))
        {
            $this->filters[]= [$filters => $value];
        }
        else{
            foreach ($filters as $key => $value)
            {
                $this->filters[]= [$key => $value];
            }
        }
        return $this;
    }

    /**
     * applies filters from the filters array to the command
     *
     */
    protected function applyFilters()
    {
        foreach ($this->filters as $filter)
        {
            // Again this is dependent on something else you need to pass the
            // command object to this piece of code to be able to work.
            $this->command->addFindCriterion(key($filter), current($filter));
        }
    }
}