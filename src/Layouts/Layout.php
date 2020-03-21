<?php

namespace EquineSolutions\Filemaker\Layouts;

use airmoi\FileMaker\Command\Command;
use airmoi\FileMaker\FileMaker;
use airmoi\FileMaker\FileMakerException;
use airmoi\FileMaker\FileMakerValidationException;
use EquineSolutions\Filemaker\Connector;
use EquineSolutions\Filemaker\Exceptions\FieldDoesNotExist;
use EquineSolutions\Filemaker\Exceptions\MethodNotAllowed;
use EquineSolutions\Filemaker\Traits\ConvertToArray;

abstract class Layout
{
    use ConvertToArray;

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
     * the sort rule variable
     *
     * @var boolean
     */
    private $sortRule;

    /**
     * the pagination flag variable
     *
     * @var boolean
     */
    private $pagination;

    /**
     * Layout constructor.
     * @param string $databaseName
     * @throws FileMakerException
     */
    public function __construct($databaseName)
    {
        $this->filemaker = (new Connector($databaseName))->filemaker();
        $this->filters = array();
        $this->pagination = false;
        $this->sortRule = [$this->getIdFieldName() => FileMaker::SORT_ASCEND];
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
     * @return string
     */
    public abstract function getIdFieldName();

    /**
     * returns the fields map
     *
     * @return array
     */
    public abstract function getFieldsMap();

    /**
     * validates the data passed to create method matches filemaker conditions
     *
     * @param $data
     * @throws MethodNotAllowed
     * @return boolean
     */
    public abstract function validateData(array $data);

    /**
     * @param FileMaker $filemaker
     */
    public function setFilemaker($filemaker)
    {
        $this->filemaker = $filemaker;
    }

    /**
     * @return FileMaker
     */
    public function getFilemaker()
    {
        return $this->filemaker;
    }

    /**
     * returns list of the resource
     *
     * @return Layout
     */
    public function index()
    {
        $this->command = $this->getFilemaker()->newFindCommand($this->getLayout());
        return $this;
    }

    /**
     * returns first element of the resource
     *
     * @return Layout
     */
    public function first()
    {
        return $this->index()->paginate(1);
    }

    /**
     * returns specified resource
     *
     * @param $id
     * @return array
     * @throws FieldDoesNotExist
     * @throws FileMakerException
     */
    public function show($id)
    {
        $this->command = $this->getFilemaker()->newFindCommand($this->getLayout());
        $this->filter($this->getIdFieldName(), '='.$id);

        return [
            'data' => $this->convertToArray($this->filemaker,
                $this->command
                    ->execute()
                    ->getRecords()
            )
        ];
    }

    /**
     * creates new resources with given data
     *
     * @param array $data
     * @return array
     * @throws FieldDoesNotExist
     * @throws FileMakerException
     * @throws FileMakerValidationException
     * @throws MethodNotAllowed
     */
    public function create(array $data)
    {
        $this->validateData($data);
        return [
            'data' => $this->convertToArray($this->filemaker,
                $this->filemaker
                    ->newAddCommand($this->getLayout(), $data)
                    ->execute()
                    ->getRecords()
            )
        ];
    }

    /**
     * updates resource with record id specified
     *
     * @param $record_id
     * @param $data
     * @return array
     * @throws FieldDoesNotExist
     * @throws FileMakerException
     * @throws FileMakerValidationException
     */
    public function edit($record_id, $data)
    {
        return [
            'data' => $this->convertToArray($this->filemaker,
                $this->filemaker
                    ->newEditCommand($this->getLayout(), $record_id, $data)
                    ->execute()
                    ->getRecords()
            )
        ];
    }

    /**
     * deletes resource with record id specified
     *
     * @param $record_id
     * @return array
     * @throws FileMakerException
     */
    public function destroy($record_id)
    {
        $this->getFilemaker()->newDeleteCommand($this->getLayout(), $record_id)->execute();
        return [
            'response' => true
        ];
    }

    /**
     * executes the find command and returns mapped array
     *
     * @return array
     * @throws FieldDoesNotExist
     * @throws FileMakerException
     */
    public function get()
    {
        $this->applyFilters();
        $this->applySort();
        $rawResponse = $this->command->execute();
        if ($this->pagination){
            $response = $this->createPaginationData($rawResponse);
        }
        $response ['data'] = $this->convertToArray($this->filemaker, $rawResponse->getRecords());
        return $response;
    }

    //      SORTING     //
    /**
     * add sorting rule asc or desc
     *
     * @param $key
     * @param $order
     * @return $this
     */
    public function sort($key, $order = 'asc')
    {
        $order = $order == 'desc'? FileMaker::SORT_DESCEND : FileMaker::SORT_ASCEND;
        $this->sortRule = [$key => $order];
        return $this;
    }

    /**
     * apply sort rule
     */
    public function applySort()
    {
        $this->command->addSortRule(key($this->sortRule), 1, current($this->sortRule));
    }
    //      END SORTING     //

    //      Filtering     //
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
            $this->command->addFindCriterion(key($filter), current($filter));
        }
    }
    //      END FILTERING     //

    //      PAGINATION     //
    /**
     * adds pagination parameters to the command
     *
     * @param $size
     * @param int $page
     * @return $this
     */
    public function paginate($size, $page = 0)
    {
        $this->pagination = true;
        $this->command->setRange($page*$size, $page*$size+$size);
        return $this;
    }

    /**
     * adds pagination data to the response
     *
     * @param $rawResponse
     * @return array
     */
    protected function createPaginationData($rawResponse)
    {
        $response = array();
        if (sizeof($rawResponse->getRecords())>0){
            $response['next_page'] = true;
        }
        else{
            $response['next_page'] = false;
        }
        return $response;
    }
    //      END PAGINATION     //


}