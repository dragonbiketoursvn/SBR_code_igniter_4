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

  public function savePaymentAsync()
  {
    // create a new payment entity with post values  
    $post = $this->request->getPost();
    $payment = new Payment($post);
    $responseContent = null;
    $monthsPaid = null;

    // validation
    if ($this->model->save($payment) === false) {

      $responseContent = ['error' => $this->model->errors()];
    } else {

      $responseContent = ['success' => 'new record inserted'];

      // we need to update 'months_paid' for the customer who's just paid
      $customersModel = new \App\Models\CustomersModel;
      $customer = $customersModel->find($payment->customer_id);

      // be sure to let the user know if no customer record is found, otherwise update the record's months_paid field
      // and save it
      if (empty($customer)) {
        $responseContent['error'] = 'customer record not found';
      } else {
        // get months_paid from the payments table and the date value from $payment to
        // update the customer record before saving
        $monthsPaid = $this->model->getTotalByCustomerID($payment->customer_id);
        $customer->months_paid = $monthsPaid->months_paid;
        $customer->last_payment = $payment->payment_date;

        if ($customersModel->save($customer) === false) {
          $responseContent['error'] = 'customer record found but not updated';
        } else {
          // we want to send the updated record back to the client so we need to make another call to the db
          $customer = $customersModel->find($payment->customer_id);
          $responseContent['customer'] = $customer;
        }
      }
    }
    return $this->response->setJSON($responseContent);
  }

  public function sendConfirmationEmailAsync()
  {
    // create a new payment entity with post values  
    $post = $this->request->getPost();
    $payment = new Payment($post);
    $responseContent = null;
    $amount = $payment->amount * 1000;
    $model = new \App\Models\CustomersModel;
    $customer = $model->where('id', $payment->customer_id)->first();

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
    $mail->Body = '<p>Hi ' . trim($customer->customer_name, "0..9") . ',</p>'
      . '<p>This message is to confirm receipt of ' . number_format($amount, 0, '.', ',') . ' đồng.</p>
                        <p>Thanks for choosing Saigon Bike Rentals!</p>';

    if (!$mail->send()) {

      $responseContent = ['error' => "'Mailer Error: ' . $mail->ErrorInfo"];
    } else {

      $path = '{sng103.hawkhost.com:993/ssl}INBOX.Sent';
      $imapStream = imap_open($path, 'patrick@saigonbikerentals.com', 'n1FaZ!Sz#)vB');
      imap_append($imapStream, $path, $mail->getSentMIMEMessage());
      imap_close($imapStream);
      $responseContent = ['success' => 'Message sent!'];
    }

    return $this->response->setJSON($responseContent);
  }
}
