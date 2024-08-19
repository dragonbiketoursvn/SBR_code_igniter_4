<?php

namespace App\Controllers\Admin;

// use App\Entities\Appointment;

class XR150Parts extends \App\Controllers\BaseController
{
  // private $model;

  // public function __construct()
  // {
  //   $this->model = new \App\Models\AppointmentsModel;
  // }

  public function viewMenu()
  {
    return view('Admin/XR150Parts/viewMenu');
  }
}
