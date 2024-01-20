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
    $this->db = \Config\Database::connect();
  }

  // private function getExchangeRates()
  // {
  //   $FIXER_API_BASE = "http://data.fixer.io/api/";
  //   $FIXER_API_KEY = "1eab7800720a67d57ee29ae5dd6ca378";
  //   $EUR_TO_USD = null;
  //   $EUR_TO_VND = null;

  //   $url = "{$FIXER_API_BASE}latest?access_key={$FIXER_API_KEY}&symbols=USD,VND";

  //   $curl = curl_init(); // initializes cURL session and returns handle
  //   curl_setopt($curl, CURLOPT_URL, $url); // sets the URL to be accessed
  //   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // transfers return value of curl_exec() as a string

  //   $resp = curl_exec($curl); // sends the request
  //   $val = json_decode($resp, $associative = true, $depth = 512);


  //   foreach ($val as $key => $item) {
  //     if (is_array($item)) {
  //       // echo $key . "=>" . implode(": ", $item) . "\n";
  //       $pre_array = implode(":", $item);
  //       $array = explode(":", $pre_array);
  //       $EUR_TO_USD = $array[0];
  //       $EUR_TO_VND = $array[1];
  //     }
  //   }
  //   $USD_TO_VND = (1 / $EUR_TO_USD) * $EUR_TO_VND;
  //   $VND_TO_USD = 1 / $USD_TO_VND;

  //   return [$USD_TO_VND, $VND_TO_USD];
  // }

  private function getExchangeRates() 
  {
    $sql = "
            SELECT price
            FROM `usd_vnd_exchange_rate`
            ORDER BY id DESC
            LIMIT 1
          ";

    $USD_TO_VND = (float) $this->db->query($sql)->getResult()[0]->price;
    $VND_TO_USD = 1 / $USD_TO_VND;
    return [$USD_TO_VND, $VND_TO_USD];
  }

  public function makeNew()
  {
    $appointment = session()->get('appointment');
    [$USD_TO_VND, $VND_TO_USD] = $this->getExchangeRates();


    //This is prevent multiple payments being recorded accidentally
    if ($appointment->paid_rent == 1) {

      return redirect()->to(site_url('Admin/Appointments/bikeStatusCheck'));
    }
    return view('Admin/Payments/makeNew', [
      'appointment' => $appointment,
      'USD_TO_VND' => $USD_TO_VND,
      'VND_TO_USD' => $VND_TO_USD
    ]);
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
