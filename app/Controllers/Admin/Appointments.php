<?php

namespace App\Controllers\Admin;

use App\Entities\Appointment;

class Appointments extends \App\Controllers\BaseController
{
  private $model;
  private $bikeStatusChangeModel;
  private $customersModel;
  private $compensationTicketsModel;
  private $compensationPaymentsModel;

  public function __construct()
  {
    $this->model = new \App\Models\AppointmentsModel;
    $this->bikeStatusChangeModel = new \App\Models\BikeStatusChangeModel;
    $this->customersModel = new \App\Models\CustomersModel;
    $this->compensationTicketsModel = new \App\Models\CompensationTicketsModel;
    $this->compensationPaymentsModel = new \App\Models\CompensationPaymentsModel;
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
    $currentBike = $this->bikeStatusChangeModel
      ->getCurrentStatus($appointment->customer_id)->plate_number;
    $appointment->current_bike = $currentBike;

    session()->set('appointment', $appointment);

    if (isset($appointment->paid_rent) && $appointment->paid_rent == 1) {

      return redirect()->to(site_url('Admin/Appointments/bikeStatusCheck'));
    }

    return view('Admin/Appointments/showDetails', ['appointment' => $appointment]);
  }

  public function paymentCheck()
  {
    $appointment = session()->get('appointment');

    if ($appointment->paid_rent == 1) {

      return redirect()->to(site_url('Admin/Appointments/bikeStatusCheck'));
    }

    if ($appointment->compensation === '1') {
      $compensationTicket = $this->compensationTicketsModel
        ->getActiveTicketsByCustomerId($appointment->customer_id);
      $appointment->compensationTicket = $compensationTicket;
      $paidToDate = $this->compensationPaymentsModel
        ->getTotalPaidOnTicket($compensationTicket->id)[0]->amount;
      $appointment->paidToDate = $paidToDate;

      return view('Admin/CompensationTickets/paymentForm', ['appointment' => $appointment]);
    } else {
      return view('Admin/Appointments/paymentCheck', ['appointment' => $appointment]);
    }
  }

  public function bikeStatusCheck()
  {
    $appointment = session()->get('appointment');

    if (($appointment->received_bike == 1) || ($appointment->returned_bike == 1)) {

      return redirect()->to(site_url('Admin/Appointments/finalCheck'));
    }

    return view('Admin/Appointments/bikeStatusCheck', ['appointment' => $appointment]);
  }

  public function getStatusChange()
  {
    $appointment = session()->get('appointment');
    $model = new \App\Models\BikesModel;
    $currentBikes = $model->getCurrentBikes();

    if (($appointment->received_bike == 0) && ($appointment->returned_bike == 0)) {

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
    $bikesModel = new \App\Models\BikesModel;
    $currentBikes = $bikesModel->getCurrentBikes();
    $currentBikesPlateNumbers = [];

    foreach ($currentBikes as $currentBike) {
      $currentBikesPlateNumbers[] = $currentBike->plate_number;
    };

    $bikeOutStatusChange = new \App\Entities\BikeStatusChange;
    $bikeInStatusChange = new \App\Entities\BikeStatusChange;
    $dateTime = $post['date_time'] !== '' ? $post['date_time'] : date('Y-m-d H:i:s');

    if (($post['bike_in'] !== '' && !(in_array($post['bike_in'], $currentBikesPlateNumbers)))
      || $post['bike_out'] !== '' && !(in_array($post['bike_out'], $currentBikesPlateNumbers))
    ) {
      return redirect()->back()->with('info', 'Kiểm Tra Lại Biển Số!');
    } elseif ($post['bike_out']) {

      //Record in the appointment record that customer received a bike
      $this->model->update($appointment->id, ['received_bike' => 1]);
      $bikeOutStatusChange->plate_number = $post['bike_out'];
      $bikeOutStatusChange->temporary = $post['temporary'];
      $bikeOutStatusChange->date_time = $dateTime;
      $bikeOutStatusChange->new_status = $appointment->customer_name;
      $bikeOutStatusChange->customer_id = $appointment->customer_id;
      $this->bikeStatusChangeModel->save($bikeOutStatusChange);

      //And set the appointment session variable
      $appointment->received_bike = 1;
    }

    if ($post['bike_in']) {

      //Record in the appointment record that customer returned a bike
      $this->model->update($appointment->id, ['returned_bike' => 1]);

      $bikeInStatusChange->plate_number = $post['bike_in'];
      $bikeInStatusChange->temporary = $post['temporary'];
      $bikeInStatusChange->date_time = $dateTime;
      $bikeInStatusChange->new_status = 'Saigon Bike Rentals';

      $this->bikeStatusChangeModel->save($bikeInStatusChange);

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

    //Mark the appointment as 'completed' now that it has finished
    $this->model->update($appointment->id, ['appointment_completed' => 1]);

    if ($appointment) {

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

      $currentCustomers = $this->customersModel->getCurrentCustomers();
      $formerCustomersOweMoney = $this->customersModel->getFormerCustomersOweMoney();
      $activeTickets = $this->compensationTicketsModel->getActiveTickets();
      $customersOweCompensation = [];

      foreach ($activeTickets as $ticket) {
        $customer = $this->customersModel->getCustomerByID($ticket->customer_id);
        $customersOweCompensation[] = $customer;
      }

      return view('Admin/Appointments/addNew', [
        'currentCustomers' => $currentCustomers,
        'formerCustomersOweMoney' => $formerCustomersOweMoney,
        'customersOweCompensation' => $customersOweCompensation
      ]);
    }
  }

  public function saveNew()
  {
    // we need to have customer_id here
    $post = $this->request->getPost();
    // $customer_name = $this->request->getPost('customer_name');
    $customer_name = $post['customer_name'];
    $customer_id = explode(':', $customer_name)[1];
    $appointment_time = date('Y-m-d H:i:s');
    $appointment = new Appointment;

    $customer = $this->customersModel->getCustomerByID($customer_id);

    $appointment->customer_name = $customer->customer_name;
    $appointment->customer_id = $customer_id;
    $appointment->appointment_time = $appointment_time;

    $currentStatus = $this->bikeStatusChangeModel->getCurrentStatus($customer_id);

    $this->model->save($appointment);
    $appointment = $this->model->getNewestRecord(); // get the saved record from model so we have its auto-generated id
    $appointment->compensation = $post['compensation'];

    session()->set('appointment', $appointment);

    return redirect()->to(site_url('Admin/Appointments/paymentCheck'));
  }
}
