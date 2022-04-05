<?php

namespace App\Controllers\Admin;

use App\Entities\Appointment;

class Appointments extends \App\Controllers\BaseController
{
  private $model;

  public function __construct()
  {
    $this->model = new \App\Models\AppointmentsModel;
  }

  public function showAll()
  {
    $scheduledAppointments = $this->model->getScheduledAppointments();
    $completedAppointments = $this->model->getCompletedAppointments();
    $appointmentTimes = [];
    $completedAppointmentTimes = [];

    foreach ($scheduledAppointments as $scheduledAppointment) {
      $appointmentTimes[] = $scheduledAppointment->appointment_time;
    }

    foreach ($completedAppointments as $completedAppointment) {
      $completedAppointmentTimes[] = $completedAppointment->appointment_time;
    }

    return view('Admin/Appointments/showAll', [
      'appointmentTimes'          => $appointmentTimes,
      'completedAppointmentTimes' => $completedAppointmentTimes
    ]);
  }

  public function showDetails($dateString)
  {
    $appointment = $this->model->where('appointment_time', $dateString)->first();

    session()->set('appointment', $appointment);

    if (isset($appointment->paid_rent) && $appointment->paid_rent == 1) {

      return redirect()->to(site_url('Admin/Appointments/bikeStatusCheck'));
    }

    return view('Admin/Appointments/showDetails', ['appointment' => $appointment]);
  }

  public function paymentCheck()
  {
    $appointment = session()->get('appointment');

    if (isset($appointment->paid_rent) && $appointment->paid_rent == 1) {

      return redirect()->to(site_url('Admin/Appointments/bikeStatusCheck'));
    }

    return view('Admin/Appointments/paymentCheck', ['appointment' => $appointment]);
  }

  public function bikeStatusCheck()
  {
    $appointment = session()->get('appointment');
    $appointment->paid_rent = 0; // to show that user has completed the paying rent question

    if ($appointment == null) {
      return view('Admin/Appointments/bikeStatusCheck', ['appointment' => $appointment]);
    }

    if (isset($appointment->paid_rent) && ($appointment->received_bike == 1) || ($appointment->returned_bike == 1)) {

      return redirect()->to(site_url('Admin/Appointments/finalCheck'));
    }

    return view('Admin/Appointments/bikeStatusCheck', ['appointment' => $appointment]);
  }

  public function getStatusChange()
  {
    $appointment = session()->get('appointment');
    $model = new \App\Models\BikesModel;
    $currentBikes = $model->getCurrentBikes();

    if (isset($appointment->paid_rent) && ($appointment->received_bike == 0) && ($appointment->returned_bike == 0)) {

      return view('Admin/Appointments/getStatusChange', [
        'appointment' => $appointment,
        'currentBikes' => $currentBikes
      ]);
    } else {

      return redirect()->to(site_url('Admin/Appointments/finalCheck'));
    }
  }

  public function saveStatusChange()
  {
    $post = $this->request->getPost();
    $appointment = session()->get('appointment');
    $model = new \App\Models\BikeStatusChangeModel;
    $bikeOutStatusChange = new \App\Entities\BikeStatusChange;
    $bikeInStatusChange = new \App\Entities\BikeStatusChange;

    if ((!$post['bike_in']) && (!$post['bike_out'])) {

      return redirect()->back()->with('info', 'Chưa Ghi Biển Số!');
    } elseif ($post['bike_out']) {

      //Record in the appointment record that customer received a bike
      $this->model->update($appointment->id, ['received_bike' => 1]);
      $bikeOutStatusChange->plate_number = $post['bike_out'];
      $bikeOutStatusChange->date_time = date('Y-m-d H:i:s');
      $bikeOutStatusChange->new_status = $appointment->customer_name;
      $bikeOutStatusChange->customer_id = $appointment->customer_id;
      $model->save($bikeOutStatusChange);

      //And set the appointment session variable
      $appointment->received_bike = 1;
    }

    if ($post['bike_in']) {

      //Record in the appointment record that customer returned a bike
      $this->model->update($appointment->id, ['returned_bike' => 1]);

      $bikeInStatusChange->plate_number = $post['bike_in'];
      $bikeInStatusChange->date_time = date('Y-m-d H:i:s');
      $bikeInStatusChange->new_status = 'Saigon Bike Rentals';

      $model->save($bikeInStatusChange);

      //And set the appointment session variable
      $appointment->returned_bike = 1;
    }

    return redirect()->to(site_url("Admin/Appointments/finalCheck"));
  }

  public function finalCheck()
  {
    $appointment = session()->get('appointment');
    return view('Admin/Appointments/finalCheck');
  }

  public function saveNotes()
  {

    $notes = $this->request->getPost('notes');
    $appointment = session()->get('appointment');

    if ($appointment) {
      //Mark the appointment as 'completed' now that it has finished
      $this->model->update($appointment->id, ['appointment_completed' => 1]);
      $this->model->update($appointment->id, ['notes' => $notes]);
    }

    //unset the session variables since we no longer need them
    session()->remove('appointment');
    session()->remove('payment');

    return redirect()->to(site_url('Admin/Home/index'));
  }

  public function addNew()
  {
    if (session()->has('appointment')) {

      return redirect()->to(site_url('Admin/Appointments/paymentCheck'));
    } else {

      $model = new \App\Models\CustomersModel;
      $currentCustomers = $model->getCurrentCustomers();

      return view('Admin/Appointments/addNew', ['currentCustomers' => $currentCustomers]);
    }
  }

  public function saveNew()
  {
    $customer_name = $this->request->getPost('customer_name');
    $appointment_time = date('Y-m-d H:i:s');
    $model = new \App\Models\CustomersModel;
    $statusChangeModel = new \App\Models\BikeStatusChangeModel;
    $appointment = new Appointment;

    $customer = $model->getCurrentCustomerByName($customer_name);
    $contract_number = $customer->id;

    $appointment->customer_name = $customer_name;
    $appointment->customer_id = $contract_number;
    $appointment->appointment_time = $appointment_time;

    $currentStatus = $statusChangeModel->getCurrentStatus($contract_number);

    $this->model->save($appointment);
    session()->set('appointment', $appointment);

    return redirect()->to(site_url('Admin/Appointments/paymentCheck'));
  }
}
