<?php

namespace App\Controllers;

use App\Models\AppointmentsModel;
use App\Libraries\Token;
use App\Libraries\Authentication;

class Appointments extends BaseController
{
  protected $model;

  public function __construct()
	{
      $this->model = new AppointmentsModel;
	}

  public function select($token = null)
	{
    $newToken = new Token($token);
    $hash = $newToken->getHash();
    $appointment = $this->model->where('activation_hash', $hash)->first();

    if(!$appointment) {

      $response = service('response');
      $response->setStatusCode(403);
      $response->setBody('You do not have permission to access that resource');

      return $response;
    };

    $scheduledAppointments = $this->model->getScheduledAppointments();

      return view('Appointments/select', [
        'token' => $token,
        'scheduledAppointments' => $scheduledAppointments
      ]);
	}

  public function chooseTime($token = null)
	{

    //if($token === null) {

    //  $response = service('response');
    //  $response->setStatusCode(403);
    //  $response->setBody('You do not have permission to access that resource');

    //  return $response;
    //  }

      $newToken = new Token($token);
      $hash = $newToken->getHash();

      $appointment = $this->model->where('activation_hash', $hash)->first();

      if(!$appointment) {

        $response = service('response');
        $response->setStatusCode(403);
        $response->setBody('You do not have permission to access that resource');

        return $response;
      };

      $this->model->update($appointment->id, [ 'appointment_time'=> $this->request->getPost('appointment_start')]);


      //return view('Appointments/select', [
        //'token' => $token,
        //'scheduledAppointments' => $scheduledAppointments
      //]);
      return view('Appointments/chooseLocation', ['appointment' => $appointment, 'token' => $token]);
      //return redirect()->to('/appointments/chooseLocation/');
	}

  public function chooseLocation($token = null)
	{
    $newToken = new Token($token);
    $hash = $newToken->getHash();
    $appointment = $this->model->where('activation_hash', $hash)->first();

    $post = $this->request->getPost();
    $appointment->fill($post);
    $this->model->save($appointment);

    $scheduledAppointments = $this->model->getScheduledAppointments();

      return redirect()->to(site_url('appointments/show/') . $token);

	}

  public function show($token = null)
  {
    $newToken = new Token($token);
    $hash = $newToken->getHash();
    $appointment = $this->model->where('activation_hash', $hash)->first();

    $scheduledAppointments = $this->model->getScheduledAppointments();

      return view('Appointments/show', [
        'token' => $token,
        'scheduledAppointments' => $scheduledAppointments
      ]);

  }

}
