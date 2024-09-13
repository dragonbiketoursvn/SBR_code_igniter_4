<?php

namespace App\Controllers\Admin;

use App\Entities\Repair;

class Repairs extends \App\Controllers\BaseController
{
  private $repairsModel;
  private $bikePartsModel;
  private $bikesModel;

  public function __construct()
  {
    $this->repairsModel = new \App\Models\RepairsModel;
    $this->bikePartsModel = new \App\Models\BikePartsModel;
    $this->bikesModel = new \App\Models\BikesModel;
  }

  public function getInfo()
  {
    $model = new \App\Models\BikesModel;
    $currentBikes = $model->getCurrentBikes();
    $partsList = $this->bikePartsModel->findDistinct();

    return view('Admin/Repairs/getInfo', [
      'currentBikes' => $currentBikes,
      'partsList' => $partsList,
    ]);
  }

  public function save()
  {
    $repair = new Repair;
    $repair->fill($this->request->getPost());
    $bikes = $this->bikesModel->getAllBikes();
    $plateNumbers = [];
    foreach ($bikes as $bike) {
      $plateNumbers[] = $bike->plate_number;
    }

    if (!(in_array($repair->plate_number, $plateNumbers))) {
      return redirect()->back()->withInput();
    }

    $result = $this->repairsModel->save($repair);
    if ($result === false) {

      return redirect()->back()->withInput();
    } else {

      return redirect()->to(site_url('Admin/Home/index'));
    }
  }

  public function updateOrDeleteForm()
  {
    $id = $this->request->getPost('id');
    $repair = $this->repairsModel->findById($id);
    $parts = $this->bikePartsModel->findDistinct();

    return view('Admin/Repairs/updateOrDeleteForm', [
      'repair' => $repair,
      'parts' => $parts
    ]);
  }

  public function updateOrDelete()
  {
    $post = $this->request->getPost();
    $repair = new Repair;
    $repair->fill($this->request->getPost());

    if ($post['delete'] === '1') {
      $this->repairsModel->delete($post['id']);
    }

    if ($this->repairsModel->skipValidation(true)->save($repair)) {
      return redirect()->to(site_url('Admin/Repairs/getHistory'));
    } else {
      return redirect()->back()->withInput();
    }
  }

  public function getHistory()
  {
    $model = new \App\Models\BikesModel;
    $currentBikes = $model->getCurrentBikes();
    $dataArray = ['currentBikes' => $currentBikes,];
    $appointments = (session()->get('appointment'));
    if ($appointments) {
      $dataArray['appointments'] = [$appointments];
    }
    return view('Admin/Repairs/getHistory', $dataArray);
  }

  public function showHistory()
  {
    $post = $this->request->getPost();
    $plateNumber = ['plate_number' => $post['plate_number']];
    $repairs = $this->repairsModel->findByPlateNumber($plateNumber);
    $repairsArray = [];

    foreach ($repairs as $repair) {

      $repairsArray[] = $repair;
    }

    if (!array_key_exists('origin', $post)) {
      return ($this->response->setJSON($repairsArray));
    } else {
      return view('Admin/Repairs/getHistory', ['plateNumber' => $plateNumber]);
    }
  }
}
