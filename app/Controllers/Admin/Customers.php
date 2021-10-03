<?php

namespace App\Controllers\Admin;

use App\Entities\Customer;

class Customers extends \App\Controllers\BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\CustomersModel;
    }

    public function contract() 
    {
        $nationalities = $this->model->getNationalities();
        $buildingNames = $this->model->getBuildingNames();
        $streetNames = $this->model->getStreetNames();
        $wards = $this->model->getWards();
        $districts = $this->model->getDistricts();
        
        $model = new \App\Models\BikesModel;
        $currentBikes = $model->getCurrentBikes();
        
        return view('Admin/Customers/contract', ['nationalities' => $nationalities, 'buildingNames' => $buildingNames, 
        'streetNames' => $streetNames, 'wards' => $wards, 'districts' => $districts, 'currentBikes' => $currentBikes]);
    }

}
