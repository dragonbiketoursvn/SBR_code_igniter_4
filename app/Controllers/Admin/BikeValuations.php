<?php

namespace App\Controllers\Admin;

use App\Entities\BikeValuation;

class BikeValuations extends \App\Controllers\BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\BikeValuationsModel;
    }

    public function getRecord()  
    {
        $model = new \App\Models\BikesModel;
        $bikeModels = $model->getCurrentModels();
                
        return view('Admin/BikeValuations/getRecord', ['bikeModels' => $bikeModels]);
    }

    public function addRecord()  
    {
        $bikeValuation = new BikeValuation();

        $bikeValuation->fill($this->request->getPost());
        
        $this->model->save($bikeValuation);
        
        return redirect()->to('Admin/BikeValuations/getRecord');
    }
    
}