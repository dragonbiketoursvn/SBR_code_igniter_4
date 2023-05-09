<?php

namespace App\Controllers\Admin;

use App\Entities\BikeStatusChange;

class MoveBike extends \App\Controllers\BaseController
{
  private $model;

  public function __construct()
  {
    $this->model = new \App\Models\BikesModel;
  }

  public function getInfo()
  {
    $currentBikes = $this->model->getCurrentBikes();
    return view('Admin/MoveBike/getInfo', ['currentBikes' => $currentBikes]);
  }

  public function save()
  {
    $bikeStatusChange = new BikeStatusChange;
    $model = new \App\Models\BikeStatusChangeModel;
    $bikeStatusChange->fill($this->request->getPost());
    $bikeStatusChange->date_time = date('Y-m-d H:i:s');

    $model->save($bikeStatusChange);

    return redirect()->to(site_url('Admin/Home/index'));
  }

  public function saveByCustomerName($customer)
  {
    $bikeStatusChange = new BikeStatusChange;
    $model = new \App\Models\BikeStatusChangeModel;
    $bikeStatusChange->fill($this->request->getPost());
    $bikeStatusChange->date_time = date('Y-m-d H:i:s');

    $model->save($bikeStatusChange);

    return redirect()->to(site_url('Admin/Home/index'));
  }
}
