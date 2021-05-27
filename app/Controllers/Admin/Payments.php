<?php

namespace App\Controllers\Admin;

use App\Entities\Payment;

class Payments extends \App\Controllers\BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\PaymentsModel;
    }

    /*
    public function showAll()
    {
      $scheduledAppointments = $this->model->getScheduledAppointments();
      $appointmentTimes = [];

      foreach ($scheduledAppointments as $scheduledAppointment) {
        $appointmentTimes[] = $scheduledAppointment->appointment_time;
      }

      return view('Admin/Appointments/showAll', ['appointmentTimes' => $appointmentTimes]);
    }

    public function getDetails($dateString)
    {
      $appointment = $this->model->where('appointment_time', $dateString)->first();

      //return view('Admin/Appointments/details', ['appointment' => $appointment]);
      return redirect()->to(site_url("Admin/Appointments/showDetails/{$dateString}"));
    }

    public function showDetails($dateString)
    {
      $appointment = $this->model->where('appointment_time', $dateString)->first();

      return view('Admin/Appointments/showDetails', ['appointment' => $appointment]);

    }

    public function startInteraction($id)
    {
      return redirect()->to(site_url("Admin/Appointments/paymentCheck/{$id}"));
    }

    public function paymentCheck($id)
    {
      $appointment = $this->model->find($id);

       return view('Admin/Appointments/paymentCheck', ['appointment' => $appointment]);
    }

    public function startBikeStatusCheck($id)
    {
      return redirect()->to(site_url("Admin/Appointments/bikeStatusCheck/{$id}"));
    }

    public function bikeStatusCheck($id)
    {
      $appointment = $this->model->find($id);

       return view('Admin/Appointments/bikeStatusCheck', ['appointment' => $appointment]);
    }

    public function startFinalCheck($id)
    {
      return redirect()->to(site_url("Admin/Appointments/finalCheck/{$id}"));
    }

    public function finalCheck($id)
    {
      $appointment = $this->model->find($id);

       return view('Admin/Appointments/finalCheck', ['appointment' => $appointment]);
    }
    */


}
