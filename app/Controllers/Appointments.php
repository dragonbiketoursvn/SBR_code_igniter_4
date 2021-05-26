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
    $alreadyBookedArray = [];
    $appointment = service('auth')->validateToken($token);
    $scheduledAppointments = $this->model->getScheduledAppointments();

    if(($appointment->appointment_time === "0000-00-00 00:00:00") || ($appointment->appointment_time === null)) {

      return view('Appointments/select', [
        'token'                   => $token,
        'scheduledAppointments'   => $scheduledAppointments,
        'alreadyBookedArray'      => $alreadyBookedArray,
      ]);

    } else {

      return redirect()->to(site_url('appointments/display/' . $token));

    }

    /*
    if(!empty($scheduledAppointments)) {

      foreach($scheduledAppointments as $scheduledAppointment) {

        if($scheduledAppointment->activation_hash === hash_hmac('sha256', $token, $_ENV['HASH_SECRET_KEY'])) {
          $currentUsersAppointment = $scheduledAppointment;
          return redirect()->to(site_url('appointments/display/' . $token));
        }
      }
    }  else {

        return view('Appointments/select', [
          'token'                   => $token,
          'scheduledAppointments'   => $scheduledAppointments,
          'alreadyBookedArray'      => $alreadyBookedArray,
        ]);

    }
    */

  }


  public function display($token = null) {

    $appointment = service('auth')->validateToken($token);

    return view('Appointments/display', [
                                          'appointment' => $appointment,
                                                'token' => $token
                                        ]);

  }

  public function chooseTime($token = null)
	{
      $appointment = service('auth')->validateToken($token);

      $this->model->update($appointment->id, [ 'appointment_time'=> $this->request->getPost('appointment_start')]);

      return redirect()->to(site_url('appointments/chooseLocation/' . $token));
	}

  public function chooseLocation($token = null)
  {
    $appointment = service('auth')->validateToken($token);

    return view('Appointments/chooseLocation', ['appointment' => $appointment, 'token' => $token]);
  }

  public function saveLocation($token = null)
	{
    $appointment = service('auth')->validateToken($token);

    $post = $this->request->getPost();

    $appointment->fill($post);

    if($appointment->hasChanged()) {

      $this->model->save($appointment);

    }

      return redirect()->to(site_url('appointments/select/' . $token));

	}

  public function delete($token = null)
	{
      $appointment = service('auth')->validateToken($token);

      $this->model->update($appointment->id, [ 'appointment_time'=> $this->request->getPost('appointment_start')]);

      //$scheduledAppointments = $this->model->getScheduledAppointments();

      return redirect()->to(site_url('appointments/select/') . $token);

	}

}
