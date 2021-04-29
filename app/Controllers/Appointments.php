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
    $alreadyBookedArray = [];
    $currentUsersAppointment = null;

    if(!$appointment) {

      $response = service('response');
      $response->setStatusCode(403);
      $response->setBody('You do not have permission to access that resource');

      return $response;
    };

    $scheduledAppointments = $this->model->getScheduledAppointments();

      return view('Appointments/select', [
        'token'                   => $token,
        'scheduledAppointments'   => $scheduledAppointments,
        'alreadyBookedArray'      => $alreadyBookedArray,
        'currentUsersAppointment' => $currentUsersAppointment
      ]);
	}

  public function chooseTime($token = null)
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

      $this->model->update($appointment->id, [ 'appointment_time'=> $this->request->getPost('appointment_start')]);


      //return view('Appointments/select', [
        //'token' => $token,
        //'scheduledAppointments' => $scheduledAppointments
      //]);
      //return view('Appointments/chooseLocation', ['appointment' => $appointment, 'token' => $token]);
      if($this->request->getPost('appointment_start') == "") {
        return redirect()->to(site_url('appointments/select/' . $token));
      }
      return redirect()->to(site_url('appointments/chooseLocation/' . $token));
	}

  public function chooseLocation($token = null)
  {
    $newToken = new Token($token);
    $hash = $newToken->getHash();
    $appointment = $this->model->where('activation_hash', $hash)->first();

    return view('Appointments/chooseLocation', ['appointment' => $appointment, 'token' => $token]);
  }

  public function saveLocation($token = null)
	{
    $newToken = new Token($token);
    $hash = $newToken->getHash();
    $appointment = $this->model->where('activation_hash', $hash)->first();

    $post = $this->request->getPost();
    $appointment->fill($post);

    if($appointment->hasChanged()) {

      $this->model->save($appointment);

    }

    $scheduledAppointments = $this->model->getScheduledAppointments();

      return redirect()->to(site_url('appointments/select/' . $token));
      //return redirect()->to(site_url('appointments/show/') . $token);

	}

  public function delete($token = null)
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

      $this->model->update($appointment->id, [ 'appointment_time'=> $this->request->getPost('appointment_start')]);

      $scheduledAppointments = $this->model->getScheduledAppointments();

      //  return view('Appointments/select', [
      //    'token' => $token,
      //    'scheduledAppointments' => $scheduledAppointments
      //  ]);

      return redirect()->to(site_url('appointments/select/') . $token);

      //return view('Appointments/select', [
        //'token' => $token,
        //'scheduledAppointments' => $scheduledAppointments
      //]);
      //return view('Appointments/chooseLocation', ['appointment' => $appointment, 'token' => $token]);
      //return redirect()->to('/appointments/chooseLocation/');
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
