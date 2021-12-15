<?php

namespace App\Controllers\Admin;

use App\Entities\Repair;

class Repairs extends \App\Controllers\BaseController
{
    private $model;
    private $bikeParts;

    public function __construct()
    {
        $this->model = new \App\Models\RepairsModel;
        $this->bikeParts = new \App\Models\BikePartsModel;
    }

    public function getInfo()
    {
      $model = new \App\Models\BikesModel;
      $currentBikes = $model->getCurrentBikes();
      $partsList = $this->bikeParts->findDistinct();

      return view('Admin/Repairs/getInfo', [
                                            'currentBikes' => $currentBikes,
                                            'partsList' => $partsList,
                                           ]);
    }

    public function save()
    {
      $repair = new Repair;
      $repair->fill($this->request->getPost());
      $result = $this->model->save($repair);
      if($result === false) {

        return redirect()->back()->withInput();

      } else {

        return redirect()->to(site_url('Admin/Home/index'));

      }
    }

    public function getHistory()
    {
      $model = new \App\Models\BikesModel;
      $currentBikes = $model->getCurrentBikes();

      return view('Admin/Repairs/getHistory', ['currentBikes' => $currentBikes,]);

    }

    public function showHistory()
    {
      $plateNumber = $this->request->getPost('plate_number');
      $repairs = $this->model->findByPlateNumber($plateNumber);
      $repairsArray = [];

      foreach ($repairs as $repair) {

        $repairsArray[] = $repair;
      }

      return($this->response->setJSON($repairsArray));      
    }

}