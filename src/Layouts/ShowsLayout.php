<?php

namespace EquineSolutions\IOCFilemaker\Layouts;

use EquineSolutions\IOCFilemaker\Connector;

class ShowsLayout implements Layout
{
    public function getLayout(){
        return 'PHP_SHOW';
    }

    public function index()
    {
        $filemaker = (new Connector())->filemaker();
        return translateALl($filemaker->newFindCommand($this->getLayout())
            ->execute()
            ->getRecords(), $filemaker);
    }

    public function show($id)
    {
        $filemaker = (new Connector())->filemaker();
        return translateALl($filemaker->newFindCommand($this->getLayout())
            ->addFindCriterion('show_id', '='.$id)
            ->execute()
            ->getRecords(), $filemaker);
    }

    public function create($data)
    {
        $filemaker = (new Connector())->filemaker();
        return translateALl($filemaker->newAddCommand($this->getLayout(), $data)
            ->execute()
            ->getRecords(), $filemaker);
    }

    public function update($record_id, $data)
    {
        $filemaker = (new Connector())->filemaker();
        return translateALl($filemaker->newEditCommand($this->getLayout(), $record_id, $data)
            ->execute()
            ->getRecords(), $filemaker);
    }

    public function delete($record_id)
    {
        $filemaker = (new Connector())->filemaker();
        return translateALl($filemaker->newDeleteCommand($this->getLayout(), $record_id)
            ->execute()
            ->getRecords(), $filemaker);
    }
}