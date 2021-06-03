<?php

namespace App\Controllers\Admin;

use App\Entities\Payment;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Payments extends \App\Controllers\BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\PaymentsModel;
    }

    public function makeNew() {

      $appointment = session()->get('appointment');

      //This is prevent multiple payments being recorded accidentally
      if($appointment->paid_rent == 1) {

        return redirect()->to(site_url('Admin/Appointments/startBikeStatusCheck'));

      }
      return view('Admin/Payments/makeNew', ['appointment' => $appointment]);
    }

    public function savePayment() {

      //Record that payment was made in appointment record
      $model = new \App\Models\AppointmentsModel;
      $appointment = session()->get('appointment');

      $model->update($appointment->id, ['paid_rent' => 1]);
      $appointment->paid_rent = 1;

      $post = $this->request->getPost();

      $contract_number = $post['contract_number'];

      //save payment info as a session variable so we can access values in sendConfirmationEmail
      session()->set('payment', $post);

      $payment = new Payment($post);

      $this->model->save($payment);

      session()->set('payment_insert_id', $this->model->getInsertID());

      //return redirect()->to(("sendConfirmationEmail/{$contract_number}"));
      return redirect()->to('sendConfirmationEmail');
      //dd($payment);
    }

    public function undoPayment() {

      //set 'paid_rent' back to 0
      $model = new \App\Models\AppointmentsModel;
      $appointment = session()->get('appointment');
      $model->update($appointment->id, ['paid_rent' => 0]);
      $appointment->paid_rent = 0;

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

    public function sendConfirmationEmail() {

      $appointment = session()->get('appointment');

      $model = new \App\Models\CustomersModel;
      $customer = $model->where('contract_number', $appointment->contract_number)->first();
      $payment = session()->get('payment');
      $amount = $payment['amount'] * 1000;

      //This is prevent multiple payments being recorded accidentally
      if($appointment->paid_rent == 1) {

        return redirect()->to(site_url('Admin/Appointments/startBikeStatusCheck'));

      }

      require ROOTPATH . '/vendor/PHPMailer-master/src/Exception.php';
      require ROOTPATH . '/vendor/PHPMailer-master/src/PHPMailer.php';
      require ROOTPATH . '/vendor/PHPMailer-master/src/SMTP.php';

      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host = 'mail.saigonbikerentals.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'patrick@saigonbikerentals.com';
      $mail->Password = 'n1FaZ!Sz#)vB';
      $mail->SMTPSecure = 'tls';
      $mail->Port = 26;
      $mail->setFrom('patrick@saigonbikerentals.com');
      $mail->addAddress($customer->email_address);
      $mail->isHTML(true);
      $mail->Subject = 'Receipt for Rental Payment';
      $mail->Body = '<p>Hi ' . $payment['customer_name'] . ',</p>'
                    . '<p>This message is to confirm receipt of ' . $amount . 'dong.</p>
                    <p>Thanks for choosing Saigon Bike Rentals!</p>';

      if (!$mail->send()) {

          echo 'Mailer Error: ' . $mail->ErrorInfo;

      } else {

          $path = '{sng103.hawkhost.com:993/ssl}INBOX.Sent';
          $imapStream = imap_open($path, 'patrick@saigonbikerentals.com', 'n1FaZ!Sz#)vB');
          imap_append($imapStream, $path, $mail->getSentMIMEMessage());
          imap_close($imapStream);
          echo 'Message sent!';

      }

      return redirect()->to(site_url('Admin/Appointments/startBikeStatusCheck'));

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
