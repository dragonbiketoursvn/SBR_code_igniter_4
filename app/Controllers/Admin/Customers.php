<?php

namespace App\Controllers\Admin;

use App\Entities\Customer;

class Customers extends \App\Controllers\BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\CustomersModel;
    }

    public function contract() 
    {
        $nationalities = $this->model->getNationalities();
        $buildingNames = $this->model->getBuildingNames();
        $streetNames = $this->model->getStreetNames();
        $wards = $this->model->getWards();
        $districts = $this->model->getDistricts();
        
        $model = new \App\Models\BikesModel;
        $currentBikes = $model->getCurrentBikes();
        
        return view('Admin/Customers/contract', ['nationalities' => $nationalities, 'buildingNames' => $buildingNames, 
        'streetNames' => $streetNames, 'wards' => $wards, 'districts' => $districts, 'currentBikes' => $currentBikes]);
    }

    public function saveNew() 
    {
        $model = new \App\Models\BikesModel;
        $dragonBikes = $model->getDragonBikes();
        $dragonBikePlateArray = [];

        foreach ($dragonBikes as $dragonBike) {
            $dragonBikePlateArray[] = $dragonBike->plate_number;
        }

        $post = $this->request->getPost();
        $customer = new Customer($post); 
        
        if (in_array($customer->current_bike, $dragonBikePlateArray)) {
            $customer->dragon_bikes = 1;
        }

        session()->set('customer', $customer);

        $this->model->save($customer);

        return redirect()->to('sendConfirmationEmail');
    }

    public function sendConfirmationEmail() {

        $customer = session()->get('customer');
        
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
        $mail->Subject = 'Motorbike Rental Contract';
        $mail->Body = '<p>Hi ' . $customer['customer_name'] . ',</p>'
                    . '<p>Below is your motorbike rental contract. This is an email contract, so please keep it in your inbox as proof of agreement. Once you have checked the terms and conditions below, please click on the link at the bottom to confirm your agreement.</p>' . 
                    '<h1 style="text-decoration: underline">A. Customer Information: </h1>
                    <ul>
                        <li><b>Name:</b></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>';

                    
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
