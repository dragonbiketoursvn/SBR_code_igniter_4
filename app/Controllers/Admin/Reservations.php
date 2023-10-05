<?php

namespace App\Controllers\Admin;

use App\Entities\Reservation;

class Reservations extends \App\Controllers\BaseController
{
  private $model;

  public function __construct()
  {
    $this->model = new \App\Models\ReservationsModel;
  }

  public function getActiveReservations()
  {
    $activeReservations = $this->model->getActiveReservations();

    return $this->response->setJSON($activeReservations);
  }
}
