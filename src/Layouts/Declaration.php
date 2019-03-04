<?php

namespace Ioc\Models;


use airmoi\FileMaker\FileMakerException;
use App\HorseDeclaration;
use Ioc\Layout;
use Ioc\Traits\IocLatestModified;
use Ioc\Traits\ShowItems;

class Declaration extends Layout
{
    use IocLatestModified, ShowItems;

    public function __construct()
    {
        parent::__construct();
    }

    public function getLayout()
    {
        return "dec_php";
    }

    public function getShowField()
    {
        return 'show_id_match';
    }

    public function mapData($data)
    {
        return array_map(function ($data)
        {
            $declaration = new HorseDeclaration();
            $declaration->competition_id =      $data['Class_ID'];
            $declaration->horse_FEI_id =        $data['Horse FEI ID'];
            $declaration->horse_qualifier =     $data['Qualifier Horse'];
            $declaration->original_id =         $data['master_id'];
            $declaration->record_id =           (int)$data['Record_id'];
            $declaration->final_master_list =   $data['FINAL MASTER LIST'];
            $declaration->event_id =            $data['event_id_match'];
            $declaration->error =               $data['Error'];
            $declaration->grand_prix =          $data['Grand Prix'];
            $declaration->filemaker_timestamp = reformatTimeStamp($data['modification timestamp']);

            return $declaration;
        }, $data);
    }

    public function update($record_id, $data)
    {
        $this->edit($record_id,
            [
                'Class_ID' => $data['class_id'],
                'DECLARATION CALCULATION' => $data['date'],
                'PHP_Q' => $data['code'],
            ]);
        $response = $this->runScriptGetResponse($record_id, 'dec_php');
        if(trim(strtolower($response)) == 'success' && $data['code'] == 'q'){
            return $this->runScriptGetResponse($record_id, 'Q_php');
        }
        return $response;
    }

    private function edit($record_id, $data)
    {
        try{
            $this->command = $this->filemaker->newEditCommand($this->getLayout(), $record_id, $data);
            $this->command->execute();
        }catch(FileMakerException $exception){
            return $exception->getMessage();
        }
    }

    private function runScriptGetResponse($record_id, $script_name)
    {
        $this->command = $this->filemaker->newFindCommand($this->getLayout());
        $this->where('Record_id', $record_id);
        $this->command->setScript($script_name);
        $this->command->execute();
        $this->command = $this->filemaker->newFindCommand($this->getLayout());
        $this->where('Record_id', $record_id);
        return $this->first()->error;
    }


}