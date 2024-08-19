<?php

namespace App\Controllers\Admin;

use App\Models\BikeStatusChangeModel;


class BikeStatusChanges extends \App\Controllers\BaseController
{
  private $model;
  // private $customersModel;

  public function __construct()
  {
    $this->model = new BikeStatusChangeModel();
    // $this->customersModel = new \App\Models\CustomersModel;
  }

  public function fetchAll()
  {
    $records = $this->model->orderBy('date_time', 'DESC')->findAll();
    return $this->response->setJSON($records);
  }
}
