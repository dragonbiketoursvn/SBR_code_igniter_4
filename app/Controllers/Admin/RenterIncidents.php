<?php

namespace App\Controllers\Admin;

use App\Entities\Customer;
use App\Entities\RenterIncident;
use App\Models\BikesModel;
use CodeIgniter\I18n\Time;

class RenterIncidents extends \App\Controllers\BaseController
{
  private $model;

  public function __construct()
  {
    $this->model = new \App\Models\RenterIncidentModel;
  }

  public function  incidents()
  {
    return view('Admin/RenterIncidents/incidents');
  }

  public function  newIncident()
  {
    $model = new \App\Models\CustomersModel;
    $bikeModel = new \App\Models\BikesModel;
    $customers = $model->getCurrentCustomers();
    $bikes =  $bikeModel->getCurrentBikes();

    return view('Admin/RenterIncidents/newIncident', ['customers' => $customers, 'bikes' => $bikes]);
  }

  public function  saveIncident()
  {
    $model = new \App\Models\CustomersModel;
    $name = $this->request->getPost('customer_name');
    $incident = new RenterIncident($this->request->getPost());
    $contractNumber;

    $customers = $model->getCurrentCustomers();

    foreach ($customers as $customer) {
      if ($customer->customer_name === $name) {

        $contractNumber = $customer->id;
      }
    }

    $incident->customer_id = $contractNumber ?? null;

    if ($this->model->save($incident)) {

      return view('Admin/RenterIncidents/success');
    } else {

      return redirect()->back();
    }
  }

  public function update($id)
  {
    $incident = $this->model->getById($id);

    return view('Admin/RenterIncidents/update', ['incident' => $incident]);
  }

  public function saveUpdate()
  {
    $incident = new RenterIncident($this->request->getPost());

    if ($this->model->save($incident)) {

      return view('Admin/RenterIncidents/success');
    }
  }

  public function  viewUnresolvedIncidents()
  {
    $incidents = $this->model->getUnresolved();

    return view('Admin/RenterIncidents/viewUnresolvedIncidents', ['incidents' => $incidents]);
  }

  public function  viewByRenter()
  {
    $model = new \App\Models\CustomersModel;
    $customers = $model->getAllCustomers();

    return view('Admin/RenterIncidents/viewByRenter', ['customers' => $customers]);
  }

  public function  showRenterHistory()
  {
    $name = $this->request->getPost('customer_name');
    $model = new \App\Models\CustomersModel;
    $incidents = $this->model->getByName($name);

    return view('Admin/RenterIncidents/showRenterHistory', ['incidents' => $incidents]);
  }

  public function  viewAll()
  {
    $incidents = $this->model->getAll();

    return view('Admin/RenterIncidents/viewAll', ['incidents' => $incidents]);
  }
}
