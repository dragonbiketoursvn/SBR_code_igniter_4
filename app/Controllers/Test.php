<?php

namespace App\Controllers;

use App\Models\BikesModel;
use App\Models\AppointmentsModel;
use App\Libraries\Token;
use App\Entities\Appointment;
use App\Models\BikeStatusChangeModel;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use CodeIgniter\I18n\Time;

class Test extends BaseController
{
  protected $db;

  public function __construct()
  {
    $this->db = \Config\Database::connect();
  }

  public function asyncRequest()
  {
    return view('Tests/asyncRequest');
  }

  public function returnValue()
  {
    // $plate_number = $_POST;
    $model = new \App\Models\BikesModel;
    $bike = $model->getBikeByPlateNumber('51R5-3876');
    // $data = ['penis' => 'enormous'];
    return $this->response->setJSON($bike);
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

  public function dailyReportReminder()
  {
    if (is_cli()) {
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
      $mail->addAddress('NGUYENVANKHANH19992@gmail.com');
      $mail->isHTML(true);
      $mail->Subject = 'Check Daily Stats/Coi Lại Thông Tin';
      $mail->Body = '<a href="http://hagiangadventures.com/Admin/Reports/getTodaysReport"><h1>Click to review/Bấm Để Xem</h1></a>';

      if (!$mail->send()) {

        echo 'Mailer Error: ' . $mail->ErrorInfo;
      }
    }
  }

  public function sendMaintenanceNotifications()
  {
    require ROOTPATH . '/vendor/PHPMailer-master/src/Exception.php';
    require ROOTPATH . '/vendor/PHPMailer-master/src/PHPMailer.php';
    require ROOTPATH . '/vendor/PHPMailer-master/src/SMTP.php';

    $model = new AppointmentsModel;

    $sql = "SELECT * FROM customers WHERE id IN (1080, 2359, 3358, 6055)"; // get our testers!
    $result = $this->db->query($sql);

    // iterate over results, create and insert new appointment record for each
    foreach ($result->getResultObject() as $row) {

      $sql2 = "SELECT plate_number 
              FROM `bike_status_change` 
              WHERE customer_id = {$row->id}
              ORDER BY date_time DESC
              LIMIT 1";

      $currentBike = $this->db->query($sql2)
        ->getResultObject()[0]
        ->plate_number;

      $name = trim($row->customer_name, "0..9");

      $appointment = new Appointment();
      $appointment->customer_id = $row->id;
      $appointment->customer_name = $row->customer_name;
      $appointment->current_bike = $currentBike;
      // $appointment->appointment_time = NULL;
      $appointment->startActivation();

      $model->insert($appointment);

      $mail = new PHPMailer(true);
      $mail->isSMTP();
      $mail->Host = 'mail.saigonbikerentals.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'patrick@saigonbikerentals.com';
      $mail->Password = 'n1FaZ!Sz#)vB';
      $mail->SMTPSecure = 'tls';
      $mail->Port = 26;
      $mail->setFrom('patrick@saigonbikerentals.com');
      $mail->addAddress($row->email_address);
      // $mail->addAddress('dragonbiketoursvn@gmail.com');
      $mail->isHTML(true);
      $mail->Subject = "Let's Meet!";

      $link = site_url("Appointments/select/{$appointment->token}");

      $mail->Body = "<p>Hi {$name},</p><p>According to our records, you are 
                    currently renting the bike with plate number <b>
                    {$currentBike}</b>, which is now due for maintenance. If this 
                    is not the correct bike please reply directly to this email 
                    and let us know. Otherwise, please click on the link below 
                    to schedule a service appointment.</p><p>Best regards,</p>
                    <p>Saigon Bike Rentals</p><p><a href='{$link}'>Book 
                    Appointment</a></p>";

      if (!$mail->send()) {

        echo 'Mailer Error: ' . $mail->ErrorInfo;
      } else {

        $path = '{sng103.hawkhost.com:993/ssl}INBOX.Sent';
        $imapStream = imap_open($path, 'patrick@saigonbikerentals.com', 'n1FaZ!Sz#)vB');
        imap_append($imapStream, $path, $mail->getSentMIMEMessage());
        imap_close($imapStream);
        echo 'Message sent!';
      }
    }
  }

  public function addPhotoPaths()
  {
    // $db = db_connect();
    $path = WRITEPATH . 'uploads/registration_cards';
    $fileNameArray = scandir($path);
    $model = new \App\Models\BikesModel;
    $bikeArray = $model->getAllBikes();

    // Iterate over all the bike records in the array
    foreach ($bikeArray as $bike) {

      // For each bike record get the names of the matching image files from the fileName array
      foreach ($fileNameArray as $row) {

        // Get the paths for the front and back of each reg and update the bike entity properties
        if (preg_match("/{$bike->plate_number}/i", $row)) {
          if (preg_match("/back/i", $row)) {
            $bike->reg_back = $row;
          } else {
            $bike->reg_front = $row;
          }
        }
      }

      // We can't use CodeIgniter's model functions since the primary key isn't explictly named 'id'
      // So, we'll have to create and run our own query
      $sql = "UPDATE bikes SET reg_front = '{$bike->reg_front}', reg_back = '{$bike->reg_back}' WHERE plate_number = '{$bike->plate_number}'";
      $this->db->query($sql);
    }
  }

  public function testPenis()
  {
    $plateNumber = '55P1-8859';
    $bikeStatusChangeModel = new BikeStatusChangeModel;
    $currentStatus = $bikeStatusChangeModel->getCurrentStatusByPlateNumber($plateNumber);
    dd($currentStatus);
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

  public function jsonTest()
  {
    $model = new \App\Models\CustomersModel;
    $customers = $model->getCurrentCustomers();
    $customer = $customers[3];

    return view('Tests/jsonTest', ['customers' => $customers, 'customer' => $customer]);
  }

  public function jsonReturn()
  {
    $model = new \App\Models\CustomersModel;
    $customers = $model->getCurrentCustomers();
    $customerEmails = [];

    foreach ($customers as $customer) {
      $customerEmails[$customer->customer_name] = $customer->email_address;
    }

    return $this->response->setJSON($customerEmails);
  }

  public function mailPhotos()
  {
    $length = count($_POST);
    $post = $this->request->getPost();
    $address = $post['address'];
    $message = $post['message'];
    $paths = []; // We'll have between one and five paths so we'll stick them in an array

    for ($i = 1; $i < ($length - 1); $i++) {
      $paths[] = $_POST['path' . $i];
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
    $mail->addAddress($address);
    $mail->isHTML(true);
    $mail->Subject = 'Bike Photos';
    $mail->Body = $message;

    foreach ($paths as $path) {

      $mail->addAttachment(WRITEPATH . 'uploads/renter_docs/' . $path);
    }

    if (!$mail->send()) {

      return $this->response->setJSON($mail->ErrorInfo);
    } else {

      return $this->response->setJSON('Success!');
    }
  }

  public function getFailedToBookMaintenanceAppointment()
  {
    // $sql = 'SELECT DISTINCT(c.customer_name), c.email_address
    //                 FROM customers c JOIN appointments a
    //                     ON c.id = a.customer_id
    //                     WHERE a.created_at > DATE_SUB(CURRENT_DATE(), INTERVAL 5 DAY)
    //                     AND a.activation_hash IS NOT NULL
    //                     AND a.appointment_time = "0000-00-00"
    //         ';

    $sql = 'SELECT DISTINCT(c.customer_name), c.email_address
                    FROM customers c JOIN appointments a
                        ON c.id = a.customer_id
                        WHERE a.created_at > DATE_SUB(CURRENT_DATE(), INTERVAL 5 DAY)
                        AND a.activation_hash IS NOT NULL
                        AND a.appointment_time = "0000-00-00"
                        AND c.id IN (
                        SELECT t1.customer_id
                        FROM ( 
                            SELECT * 
                            FROM bike_status_change
                            WHERE (plate_number, date_time) 
                            IN
                            (
                                SELECT t1.plate_number, MAX(t1.date_time) AS date_time
                                FROM
                                (
                                    SELECT * FROM bike_status_change 
                                    WHERE (customer_id, date_time) IN ( 
                                        SELECT customer_id, MAX(date_time) AS date_time FROM bike_status_change 
                                        WHERE customer_id IN ( 
                                            SELECT id FROM customers WHERE currently_renting = 1 
                                        ) 
                                        GROUP BY customer_id 
                                    )
                                )t1
                                GROUP BY t1.plate_number
                            )
                                ) t1 JOIN ( 
                                    SELECT plate_number, MAX(repair_date) AS repair_date
                                    FROM repairs 
                                    WHERE nhot = 1 
                                    AND plate_number NOT IN ( 
                                        SELECT plate_number 
                                        FROM bikes 
                                        WHERE sale_date > "2000-01-01" 
                                    ) 
                                    GROUP BY plate_number 
                                    HAVING MAX(repair_date) < DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL 3 MONTH) 
                                    ORDER BY MAX(repair_date) 
                                    ) t2 
                                    ON t1.plate_number = t2.plate_number 
                                    JOIN customers c on c.id = t1.customer_id  
                                    )';

    $db = db_connect();

    return $db->query($sql);
  }

  public function remindFailedToBookMaintenanceAppointment()
  {
    if (is_cli()) {
      require ROOTPATH . '/vendor/PHPMailer-master/src/Exception.php';
      require ROOTPATH . '/vendor/PHPMailer-master/src/PHPMailer.php';
      require ROOTPATH . '/vendor/PHPMailer-master/src/SMTP.php';

      $resultArray = $this->getFailedToBookMaintenanceAppointment()->getResultArray();
      $table = '<table style="border: 2px solid black; border-collapse: collapse">';

      foreach ($resultArray as $record) {

        $table .= "<tr><td style='border: 1px solid black; padding: 2px'>{$record['customer_name']}</td><td style='border: 1px solid black; padding: 2px'>{$record['email_address']}</td></tr>";
      }

      $table .= '</table>';

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
      $mail->Subject = "No Response to Bike Maintenance Notification";

      $mail->Body = "<p>The following renters have not yet responded to the most recent notification:</p>{$table}";

      if (!$mail->send()) {

        echo 'Mailer Error: ' . $mail->ErrorInfo;
      } else {

        $path = '{sng103.hawkhost.com:993/ssl}INBOX.Sent';
        $imapStream = imap_open($path, 'patrick@saigonbikerentals.com', 'n1FaZ!Sz#)vB');
        imap_append($imapStream, $path, $mail->getSentMIMEMessage());
        imap_close($imapStream);
        echo 'Message sent!';
      }
    }
  }
}
