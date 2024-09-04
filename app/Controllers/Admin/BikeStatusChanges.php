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

  // public function fetchLastSixMonths()
  // {
  //   $records = $this->model->getLastSixMonths();
  //   dd($records);
  //   return $this->response->setJSON($records);
  // }

  public function viewLastSixMonths()
  {
    $records = $this->model->getLastSixMonths();
    return view('Admin/BikeStatusChanges/viewLastSixMonths', ['records' => $records]);
  }


  public function viewInfo()
  {
    $id = $this->request->getPost('id');

    if (!$id) {
      return redirect()->back();
    }

    $bikeStatusChange = $this->model->getById($id);

    if (!$bikeStatusChange) {
      return redirect()->back();
    }

    return view('Admin/BikeStatusChanges/update', [
      'bikeStatusChange' => $bikeStatusChange
    ]);
  }

  public function saveUpdate()
  {
    $post = $this->request->getPost();
    $bikeStatusChange = $this->model->getById($post['id']);
    $bikeStatusChange->date_time = $post['date_time'];
    $bikeStatusChange->temporary = $post['temporary'];

    if ($this->model->save($bikeStatusChange)) {
      return redirect()->to(site_url('Admin/BikeStatusChanges/viewLastSixMonths'));
    } else {
      return redirect()->back();
    }
  }


  public function fetchByPlateNumber()
  {
    $plateNumber = $this->request->getPost('plate_number');
    $statusChanges = $this->model->getStatusHistoryByPlateNumber($plateNumber);
    $statusChangesArray = [];

    foreach ($statusChanges as $statusChange) {

      $statusChangesArray[] = $statusChange;
    }

    return ($this->response->setJSON($statusChangesArray));
  }
}
