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

  public function makeNew()
  {

    $appointment = session()->get('appointment');

    //This is prevent multiple payments being recorded accidentally
    if ($appointment->paid_rent == 1) {

      return redirect()->to(site_url('Admin/Appointments/bikeStatusCheck'));
    }
    return view('Admin/Payments/makeNew', ['appointment' => $appointment]);
  }

  public function savePayment()
  {

    //Record that payment was made in appointment record
    $model = new \App\Models\AppointmentsModel;
    $appointment = session()->get('appointment');

    if ($appointment->paid_rent === 1) {

      return redirect()->to(site_url('Admin/Appointments/bikeStatusCheck'));
    } else {

      $post = $this->request->getPost();
      $payment = new Payment($post);
      //$contract_number = $post['contract_number'];

      //validation
      if ($this->model->save($payment) === false) {

        return redirect()->back()->with('errors', $this->model->errors())
          ->withInput();
      } else {

        //save payment info as a session variable so we can access values in sendConfirmationEmail
        session()->set('payment', $post);

        $model->update($appointment->id, ['paid_rent' => 1]);
        $appointment->paid_rent = 1;

        return redirect()->to(site_url('Admin/Payments/sendConfirmationEmail'));
      }
    }
  }

  public function update($id)
  {
    $payment = $this->model->find($id);

    return view('Admin/Payments/update', ['payment' => $payment]);
  }

  public function saveUpdate()
  {
    $payment = $this->request->getPost();

    if ($this->model->save($payment)) {

      return redirect()->to(site_url('Admin/Home/index'));
    } else {

      return redirect()->back()->with('errors', $this->model->errors());
    }
  }

  public function sendConfirmationEmail()
  {

    $appointment = session()->get('appointment');

    if ($appointment->sent_email === 1) {

      return redirect()->to(site_url('Admin/Appointments/bikeStatusCheck'));
    } else {



      $model = new \App\Models\CustomersModel;
      $customer = $model->where('id', $appointment->customer_id)->first();
      $payment = session()->get('payment');
      $amount = $payment['amount'] * 1000;

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
      $mail->Body = '<p>Hi ' . trim($payment['customer_name'], "0..9") . ',</p>'
        . '<p>This message is to confirm receipt of ' . number_format($amount, 0, '.', ',') . ' đồng.</p>
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

      $appointment->sent_email = 1;

      return redirect()->to(site_url('Admin/Appointments/bikeStatusCheck'));
    }
  }
}
