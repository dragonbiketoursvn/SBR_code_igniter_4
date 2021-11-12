<?php

namespace App\Controllers;

use App\Models\BikesModel;
use App\Libraries\Token;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use CodeIgniter\I18n\Time;

class Test extends BaseController
{

  public function testOne()
  {
    return view('Tests/testOne.php');
  }


  public function testTwo()
  {
    // $path = $this->request->getFile('photo')->store('images/');
    $file = $this->request->getFile('photo');
    $path = $file->store('images/');
    $path = WRITEPATH . 'uploads/' . $path;
    $path = urlencode($path);
    dd($path);
    // $name = $file->getName();

    // return view('Tests/testTwo', ['name' => $name]);
    return view('Tests/testTwo', ['path' => $path]);
  }

  public function showImage($path)
  {
    $path = WRITEPATH . 'uploads/images/' . $name;

    $finfo = new \finfo(FILEINFO_MIME);

    $type = $finfo->file($path);

    header("Content-Type: $type");
    header("Content-Length: " . filesize($path));

    readfile($path);
    exit;
  }

  public function sendActivationEmail()
  {
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
    $mail->addAddress('dragonbiketoursvn@gmail.com');
    $mail->isHTML(true);
    $mail->Subject = 'Rental Agreement';
    $mail->Body = 'hello';
    $mail->addAttachment(WRITEPATH . 'uploads/images/1635835163_27218a1fdb467e958310.png');

    if (!$mail->send()) {

      echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
  }

  public function addPhotoPaths()
  {
    // $db = db_connect();
    // $path = WRITEPATH . 'uploads/registration_cards';
    // $fileNameArray = scandir($path);
    // $model = new \App\Models\BikesModel;
    // $bikeArray = $model->getAllBikes();

    // // Iterate over all the bike records in the array
    // foreach ($bikeArray as $bike) {

    //   // For each bike record get the names of the matching image files from the fileName array
    //     foreach ($fileNameArray as $row) {

    //         // Get the paths for the front and back of each reg and update the bike entity properties
    //         if(preg_match("/{$bike->plate_number}/i", $row)) {
    //             if(preg_match("/back/i", $row)) {
    //                 $bike->reg_back = $row;
    //             } else {
    //                 $bike->reg_front = $row;                                        
    //             }
    //         }
    //     }

    //     // We can't use CodeIgniter's model functions since the primary key isn't explictly named 'id'
    //     // So, we'll have to create and run our own query
    //     $sql = "UPDATE bikes SET reg_front = '{$bike->reg_front}', reg_back = '{$bike->reg_back}' WHERE plate_number = '{$bike->plate_number}'";
    //     $db->simpleQuery($sql);

  }

  public function testPenis()
  {
    $db = db_connect();
    $sql = "SELECT plate_number, purchase_date, brand, model, year, purchase_price, extra_key, sale_date, sale_price FROM bikes WHERE plate_number = '51K2-1782'";

    // $result = $db->query($sql);

    $result  = $db->query($sql);
    // $fields = $query->fieldData();

    $fieldData = $result->getFieldData();

    $names = [];
    $types = [];

    for ($i = 0; $i < count($fieldData); $i++) {
      $names[] = $fieldData[$i]->name;
      $types[] = $fieldData[$i]->type_name;
    }

    return view('Tests/testPenis', ['fieldData' => $fieldData]);
  }

  public function  viewCurrentCustomers()
  {
    $model = new \App\Models\CustomersModel;
    $paymentsModel = new \App\Models\PaymentsModel;

    // $customersResultObject = $model->select('id, customer_name, nationality, rent, start_date, finish_date')
    //   ->get();

    // $fields = $customersResultObject->getFieldData();
    // $customers = $customersResultObject->getResult();

    $customers = $model->getCurrentCustomers();

    foreach ($customers as $customer) {
      // $payments = $paymentsModel->getByContractNumber($customer->id);
      $monthsPaid = $paymentsModel->getTotalMonthsPaid($customer->id)->months_paid ?? 0;
      $startDate = new Time();
      $startDate = $startDate->createFromFormat('Y-m-d', $customer->start_date);
      $paidUpTo = $startDate->addMonths($monthsPaid)->toDateString();
      $payments = $paymentsModel->getByContractNumber($customer->id);

      $customer->paid_up_to = $paidUpTo;
      if (count($payments) > 0) {
        $customer->last_payment = $payments[0]->payment_date;
      }
    }

    usort($customers, function ($customerA, $customerB) {
      if ($customerA->paid_up_to == $customerB->paid_up_to) {
        return 0;
      }
      return ($customerA->paid_up_to < $customerB->paid_up_to) ? -1 : 1;
    });

    return view('Tests/viewCurrentCustomers', ['customers' => $customers]);
  }

  public function  viewAllCustomers()
  {
    $model = new \App\Models\CustomersModel;
    $customers = $model->getAllCustomers();

    return view('Tests/viewAllCustomers', ['customers' => $customers]);
  }

  public function selectCustomerView()
  {
    return view('Tests/selectCustomerView');
  }
}
