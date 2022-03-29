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

    // if bike's new status is with a customer then customer_id will be set
    if (isset($bikeStatusChange->customer_id)) {
      // if so, grab the customers model and find the record with matching id
      $customersModel = new \App\Models\CustomersModel;
      $customer = $customersModel->getCustomerById($bikeStatusChange->customer_id);
      // update the customer record's current_bike field with the value of the bike whose status is changing and save it
      $customer->current_bike = $bikeStatusChange->plate_number;
      $customersModel->save($customer);
    }

    $model->save($bikeStatusChange);

    return redirect()->to(site_url('Admin/Home/index'));

    //     save bike_status_change should check if customer_id
    // is set and if so update customers(current_bike) with value of plate_number
  }

  public function saveAsync()
  {
    $bikeStatusChange = new BikeStatusChange;
    $model = new \App\Models\BikeStatusChangeModel;
    $bikeStatusChange->fill($this->request->getPost());
    $bikeStatusChange->date_time = date('Y-m-d H:i:s');
    $responseContent = null;

    if (!$model->save($bikeStatusChange)) {
      $responseContent = ['error' => 'status change record not created'];
    } else {

      $responseContent = ['success' => 'new record inserted'];
    }

    // if bike's new status is with a customer then customer_id will be set
    if (!empty($bikeStatusChange->customer_id)) {
      // if so, grab the customers model and find the record with matching id
      $customersModel = new \App\Models\CustomersModel;
      $customer = $customersModel->getCustomerById($bikeStatusChange->customer_id);


      // update the customer record's current_bike field with the value of the bike whose status is changing and save it
      $customer->current_bike = $bikeStatusChange->plate_number;
      if ($customersModel->save($customer)) {

        // if we've successfully updated the customer record then we need to update it on the client side as well
        $responseContent = ['success' => 'current_bike field updated'];
        $responseContent['customer'] = $customer;
        return $this->response->setJSON($responseContent);
      }
    }

    return $this->response->setJSON($responseContent);
  }
}
