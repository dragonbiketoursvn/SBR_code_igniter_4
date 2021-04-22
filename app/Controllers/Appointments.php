<?php

namespace App\Controllers;

use App\Models\AppointmentsModel;
use App\Libraries\Token;

class Appointments extends BaseController
{
  protected $model;

  //$this->model = new AppointmentsModel;

  public function __construct()
	{
      $this->model = new AppointmentsModel;
	}

  public function select($token = null)
	{

    if($token === null) {

      $response = service('response');
      $response->setStatusCode(403);
      $response->setBody('You do not have permission to access that resource');

      return $response;
    }

      return view('Appointments/select', ['token' => $token]);
	}

  public function create($token = null)
	{

    if($token === null) {

      $response = service('response');
      $response->setStatusCode(403);
      $response->setBody('You do not have permission to access that resource');

      return $response;
    }
      $newToken = new Token($token);
      $hash = $newToken->getHash();

      $appointment = $this->model->where('activation_hash', $hash)->first();

      $this->model->update($appointment->id, [ 'appointment_time'=> $this->request->getPost('appointment_start')]);
      
      return view('Appointments/success');
	}
}
