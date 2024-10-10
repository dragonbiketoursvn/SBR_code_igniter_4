<?php

namespace App\Controllers\Admin;

use App\Entities\CompensationTicket;

class CompensationTickets extends \App\Controllers\BaseController
{
  private $model;
  private $bikesModel;
  // private $bikeStatusChangeModel;
  // private $db;
  private $currentBikes;


  public function __construct()
  {
    $this->model = new \App\Models\CompensationTicketsModel;
    $this->bikesModel = new \App\Models\BikesModel;
    // $this->bikeStatusChangeModel = new \App\Models\BikeStatusChangeModel;
    // $this->db = \Config\Database::connect();

    $this->currentBikes = $this->bikesModel->getCurrentBikes();
  }

  public function addForm($customerId)
  {
    return view('Admin/CompensationTickets/addForm', [
      'bikes' => $this->currentBikes,
      // 'models' => $models,
      'customerId' => $customerId,
    ]);
  }

  public function create()
  {
    $compensationTicket = new CompensationTicket($this->request->getPost());
    $compensationTicket->active = 1;
    // $compensationTicket->still_outstanding = $compensationTicket->cost_incurred;

    if (in_array($compensationTicket->stolen_destroyed_damaged, ['STOLEN', 'DESTROYED'])) {
      $bike = $this->bikesModel->getBikeByPlateNumber($compensationTicket->plate_number);
      $bike->sale_date = $compensationTicket->date;
    }

    if ($this->model->save($compensationTicket)) {
      return redirect()->to(site_url('Admin/Customers/viewCurrentCustomers'));
    } else {
      return redirect()->back()->with('errors', ['error' => 'too bad!']);
    }
  }

  public function update()
  {
    $post = $this->request->getPost();
    $compensationTicket = new CompensationTicket($post);
    // We're going to pass this data to the view so it redisplays the updated record on loading
    session()->setFlashdata('plate_number', $compensationTicket->compensation_plate_number);

    if ($this->model->save($compensationTicket)) {
      return redirect()->to(site_url('Admin/Bikes/viewIndividual'));
    } else {
      return redirect()->back()->with('errors', ['error' => 'too bad!']);
    }
  }

  public function savePayment()
  {
    $post = $this->request->getPost();
  }
}
