<?php

namespace EquineSolutions\IOCFilemaker\Traits;

trait Paginate
{
    /**
     * adds pagination parameters to the command
     *
     * @param $size
     * @param int $page
     * @return $this
     */
    public function paginate($size, $page = 0)
    {
        // Same concept $this->>command how can I know that the parent class has a command attribute.
        // The command needs to be passed into the method to perform what ever operations it needs on it

        $this->command->setRange($page*$size, $page*$size+$size);
        return $this;
    }

    /**
     * adds pagination data to the response
     *
     * @param $response
     */
    protected function attachPaginationData(&$response)
    {
        $max = key_exists('max', $this->command->getRange())? $this->command->getRange()['max']:null;
        if (!$max || $max == 1 || $this->skip_last_record){
            return;
        }
        $skip = $this->command->getRange()['skip'];
        $size = $max-$skip;
        $page = $max/$size;
        if (!$this->last_record_id){
            $this->setLastRecordId();
        }
        $response['last_id'] = $this->last_record_id;
        if ((int)$response['data'][sizeof($response['data'])-1][$this->getIdFieldKeyName()] == $this->last_record_id){
            $response['next_page'] = null;
        }
        else{
            $response['next_page'] = $page;
        }
    }

}