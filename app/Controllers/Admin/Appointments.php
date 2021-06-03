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
      $appointmentTimes = [];

      foreach ($scheduledAppointments as $scheduledAppointment) {
        $appointmentTimes[] = $scheduledAppointment->appointment_time;
      }

      return view('Admin/Appointments/showAll', ['appointmentTimes' => $appointmentTimes]);
    }

    public function getDetails($dateString)
    {
      $appointment = $this->model->where('appointment_time', $dateString)->first();

      session()->set('appointment', $appointment);

      //return view('Admin/Appointments/details', ['appointment' => $appointment]);
      //return redirect()->to(site_url("Admin/Appointments/showDetails/{$dateString}"));
      return redirect()->to(site_url("Admin/Appointments/showDetails"));
    }

    public function showDetails()
    {
      $appointment = session()->get('appointment');

      if($appointment->paid_rent == 1) {

        return redirect()->to('bikeStatusCheck');

      }

      return view('Admin/Appointments/showDetails', ['appointment' => $appointment]);

    }

    /*
    public function startInteraction($id)
    {
      return redirect()->to(site_url("Admin/Appointments/paymentCheck/{$id}"));
    }
    */

    public function paymentCheck()
    {
      $appointment = session()->get('appointment');

      //Mark the appointment as 'completed' now that it has started
      $this->model->update($appointment->id, ['appointment_completed' => 1]);

      if($appointment->paid_rent == 1) {

        return redirect()->to('bikeStatusCheck');

      }

      return view('Admin/Appointments/paymentCheck', ['appointment' => $appointment]);
    }

    public function startBikeStatusCheck()
    {
      return redirect()->to(site_url("Admin/Appointments/bikeStatusCheck"));
    }

    public function bikeStatusCheck()
    {
      $appointment = session()->get('appointment');

      if(($appointment->received_bike == 1) || ($appointment->returned_bike == 1)) {

        return redirect()->to('finalCheck');

      }

      return view('Admin/Appointments/bikeStatusCheck', ['appointment' => $appointment]);

    }

    public function getStatusChange()
    {
      $appointment = session()->get('appointment');
      $model = new \App\Models\BikesModel;
      $currentBikes = $model->getCurrentBikes();

      if(($appointment->received_bike == 0) && ($appointment->returned_bike == 0)) {

      return view('Admin/Appointments/getStatusChange', ['appointment' => $appointment,
                                                         'currentBikes' => $currentBikes]);
      } else {

          return redirect()->to('finalCheck');

      }
    }

    public function saveStatusChange()
    {
      $post = $this->request->getPost();
      $appointment = session()->get('appointment');
      $model = new \App\Models\BikeStatusChangeModel;
      $bikeStatusChange = new \App\Entities\BikeStatusChange;

      if((! $post['bike_in']) && (! $post['bike_out'])) {

        return redirect()->back()->with('info', 'Chưa Ghi Biển Số!');

      } elseif($post['bike_out']) {

          //Record in the appointment record that customer received a bike
          $this->model->update($appointment->id, ['received_bike' => 1]);
          $bikeStatusChange->plate_number = $post['bike_out'];
          $bikeStatusChange->date_time = date('Y-m-d H:i:s');
          $bikeStatusChange->new_status = $appointment->customer_name;
          $bikeStatusChange->contract_number = $appointment->contract_number;
          $model->save($bikeStatusChange);

          //And set the appointment session variable
          $appointment->received_bike = 1;
        }

       if($post['bike_in']) {

          //Record in the appointment record that customer returned a bike
          $this->model->update($appointment->id, ['returned_bike' => 1]);

          $bikeStatusChange->plate_number = $post['bike_in'];
          $bikeStatusChange->date_time = date('Y-m-d H:i:s');
          $bikeStatusChange->new_status = 'Saigon Bike Rentals';
          $model->save($bikeStatusChange);

          //And set the appointment session variable
          $appointment->returned_bike = 1;

        }

      return redirect()->to(site_url("Admin/Appointments/finalCheck"));

    }

    public function undoPayment() {

      //set 'received_bike' and 'returned_bike' back to 0
      $statusModel = new \App\Models\BikeStatusChangeModel;

      $appointment = session()->get('appointment');
      $this->model->update($appointment->id, ['received_bike' => 0,
                                              'returned_bike' => 0]);
      $appointment->received_bike = 0;
      $appointment->received_bike = 0;
      //delete last payment from db
      $this->model->delete(session()->get('payment_insert_id'));

      //$post = $this->request->getPost();

      //$contract_number = $post['contract_number'];

      //save payment info as a session variable so we can access values in sendConfirmationEmail
      //session()->set('payment', $post);

      //$payment = new Payment($post);

      //$this->model->save($payment);

      return redirect()->to(site_url('Admin/Appointments/paymentCheck'));

    }

    public function finalCheck()
    {
       $appointment = session()->get('appointment');
       return view('Admin/Appointments/finalCheck');
    }

    public function saveNotes() {

      $notes = $this->request->getPost('notes');
      $appointment = session()->get('appointment');

      if($appointment) {

        $this->model->update($appointment->id, ['notes' => $notes]);

      }

      //unset the session variables since we no longer need them
      session()->remove('appointment');
      session()->remove('payment');

      return redirect()->to(site_url('Admin/Home/index'));

    }

}
