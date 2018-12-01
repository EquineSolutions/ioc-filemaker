<?php

namespace EquineSolutions\IOCFilemaker\Layouts;


use airmoi\FileMaker\Command\Command;
use airmoi\FileMaker\FileMaker;
use EquineSolutions\IOCFilemaker\Connector;
use EquineSolutions\IOCFilemaker\Traits\ConvertToArray;
use EquineSolutions\IOCFilemaker\Traits\Filter;
use EquineSolutions\IOCFilemaker\Traits\Paginate;
use EquineSolutions\IOCFilemaker\Traits\Sort;

abstract class Layout
{
    use Filter, ConvertToArray, Paginate, Sort;

    /**
     * The filemaker class.
     *
     * @var FileMaker
     */
    protected $filemaker;

    /**
     * The command class.
     *
     * @var Command
     */
    protected $command;

    /**
     * The filters array
     *
     * @var array
     */
    protected $filters;

    /**
     * The filters array
     *
     * @var int
     */
    protected $last_record_id;

    /**
     * indicates whether getting last variable or paginating to stop recursion
     *
     * @var boolean
     */
    private $skip_last_record;

    /**
     * the sort rule variable
     *
     * @var boolean
     */
    private $sort_rule;

    /**
     * Layout constructor.
     */
    public function __construct()
    {
        $this->filemaker = (new Connector())->filemaker();
        $this->filters = array();
        $this->last_record_id = null;
        $this->skip_last_record = false;
        $this->sort_rule = [$this->getIdFieldName() => FileMaker::SORT_ASCEND];
    }

    /**
     * returns the name of the layout
     *
     * @return string
     */
    protected abstract function getLayout();

    /**
     * returns the field name
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    protected abstract function getIdFieldName();

    /**
     * returns the fields map
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public abstract function getFieldsMap();

    /**
     * returns list of the resource
     *
     * @return Layout
     */
    public function index()
    {
        $this->command = $this->filemaker->newFindCommand($this->getLayout());
        return $this;
    }

    /**
     * returns specified resource
     *
     * @param $id
     * @return Layout
     */
    public function show($id)
    {
        $this->command = $this->filemaker->newFindCommand($this->getLayout());
        $this->filter($this->getIdFieldName(), '='.$id);
        return $this;
    }

    /**
     * creates new resources with given data
     *
     * @param $data
     * @return Layout
     */
    public function create($data)
    {
        $this->command = $this->filemaker->newAddCommand($this->getLayout(), $data);
        return $this;
    }

    /**
     * updates resource with record id specified
     *
     * @param $record_id
     * @param $data
     * @return Layout
     */
    public function edit($record_id, $data)
    {
        $this->command = $this->filemaker->newEditCommand($this->getLayout(), $record_id, $data);
        return $this;
    }

    /**
     * deletes resource with record id specified
     *
     * @param $record_id
     * @return Layout
     */
    public function destroy($record_id)
    {
        $this->command = $this->filemaker->newDeleteCommand($this->getLayout(), $record_id);
        return $this;
    }

    /**
     * executes the find command and returns mapped array
     *
     * @return array
     */
    public function get()
    {
        $this->applyFilters();
        $this->applySort();
        $response = [
            'data' => $this->convertToArray($this->command->execute()->getRecords())
        ];
        $this->attachPaginationData($response);
        return $response;
    }

    /**
     * executes the insert command and returns mapped array of the created object or throws exception
     *
     * @return array
     */
    public function post()
    {
        $response = [
            'data' => $this->convertToArray($this->command->execute()->getRecords())
        ];
        return $response;
    }

    /**
     * executes the edit command and returns  mapped array of the updated object or throws exception
     *
     * @return array
     */
    public function update()
    {
        $response = [
            'data' => $this->convertToArray($this->command->execute()->getRecords())
        ];
        return $response;
    }

    /**
     * executes the delete command and returns true or throws exception
     *
     * @return array
     */
    public function delete()
    {
        $this->command->execute();
        return [
            'response' => true
        ];
    }

    /**
     * sets the last record id variable by using pagination with size of 1 to a sorted descending result
     *
     * @return void
     */
    public function setLastRecordId()
    {
        $this->skip_last_record = true;
        $old_sort_rule = $this->sort_rule;
        $order = current($this->sort_rule) == FileMaker::SORT_DESCEND? 'asc':'desc';
        $this->last_record_id =  (int)$this->index()
            ->sort(key($this->sort_rule), $order)
            ->paginate(1, 0)
            ->get()['data'][0]['id'];
        $this->sort_rule = $old_sort_rule;
        $this->skip_last_record = false;
    }

}