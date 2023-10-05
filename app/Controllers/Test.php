<?php

namespace App\Controllers;

use App\Models\BikesModel;
use App\Models\AppointmentsModel;
use App\Libraries\Token;
use App\Entities\Appointment;
use App\Models\BikeStatusChangeModel;
use App\Entities\InventoryChange;
use App\Models\InventoryChangesModel;

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
      $mail->isHTML(true);
      $mail->Subject = 'Check Daily Stats/Coi Lại Thông Tin';
      $mail->Body = '<a href="http://hagiangadventures.com/Admin/Reports/getTodaysReport"><h1>Click to review/Bấm Để Xem</h1></a>';

      if (!$mail->send()) {

        echo 'Mailer Error: ' . $mail->ErrorInfo;
      }
    }
  }

  public function getBikesInOilDangerZone()
  {
    $sql = 'SELECT b.plate_number, b.brand, b.model, MAX(r.repair_date) AS latest_oil_change 
            FROM bikes b JOIN repairs r ON b.plate_number = r.plate_number 
            WHERE b.sale_date = "0000-00-00" 
            OR b.sale_date IS NULL 
            AND r.nhot = 1 OR b.plate_number NOT IN ( 
              SELECT plate_number 
              FROM repairs 
              WHERE nhot = 1 
              AND repair_date > "2022-07-01" 
              ) 
            GROUP BY b.plate_number, b.brand, b.model 
            HAVING latest_oil_change > "2022-07-01" 
            AND latest_oil_change < DATE_SUB(CURRENT_DATE(), INTERVAL 4 MONTH)
            ORDER BY `latest_oil_change` ASC
    ';
    return $this->db->query($sql);
  }

  public function sendOilDangerZoneWarning()
  {
    $resultArray = $this->getBikesInOilDangerZone()->getResultArray();

    if (is_cli() && count($resultArray) > 0) {
      require ROOTPATH . '/vendor/PHPMailer-master/src/Exception.php';
      require ROOTPATH . '/vendor/PHPMailer-master/src/PHPMailer.php';
      require ROOTPATH . '/vendor/PHPMailer-master/src/SMTP.php';

      $table = '<table style="border: 2px solid black; border-collapse: collapse">
                <tr><th style="border: 1px solid black; padding: 2px">PLATE NUMBER</th>
                <th style="border: 1px solid black; padding: 2px">BRAND</th>
                <th style="border: 1px solid black; padding: 2px">MODEL</th>
                <th style="border: 1px solid black; padding: 2px">LATEST OIL CHANGE</th></tr>';

      foreach ($resultArray as $record) {

        $table .= "<tr><td style='border: 1px solid black; padding: 2px'>{$record['plate_number']}</td>
                  <td style='border: 1px solid black; padding: 2px'>{$record['brand']}</td>
                  <td style='border: 1px solid black; padding: 2px'>{$record['model']}</td>
                  <td style='border: 1px solid black; padding: 2px'>{$record['latest_oil_change']}</td></tr>";
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
      $mail->Subject = "Bikes In Oil Danger Zone";

      $mail->Body = "<p>The following bikes are dangerously overdue for an oil change:</p>{$table}";

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

  public function getMaintenanceList()
  {
    $sql = 'SELECT SUBSTRING_INDEX(t1.plate_number, " ", 1) AS plate_number, t1.customer_id, c.customer_name, c.email_address
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
            LIMIT 40
            ';

    $db = db_connect();

    return $db->query($sql);
  }

  public function sendEmailsToMaintenanceList()
  {
    if (is_cli()) {
      require ROOTPATH . '/vendor/PHPMailer-master/src/Exception.php';
      require ROOTPATH . '/vendor/PHPMailer-master/src/PHPMailer.php';
      require ROOTPATH . '/vendor/PHPMailer-master/src/SMTP.php';

      $resultArray = $this->getMaintenanceList()->getResultArray();
      $model = new AppointmentsModel;

      foreach ($resultArray as $row) {
        $name = trim($row['customer_name'], "0..9");
        $email = $row['email_address'];
        $plateNumber = $row['plate_number'];
        $customerID = $row['customer_id'];

        $appointment = new Appointment();
        $appointment->customer_id = $customerID;
        $appointment->customer_name = $name;
        $appointment->current_bike = $plateNumber;
        $appointment->appointment_time = NULL;
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
        // $mail->addAddress($email);
        $mail->addAddress('dragonbiketoursvn@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = "Bike Maintenance";

        $link = site_url("Appointments/select/{$appointment->token}");

        $mail->Body = "<p>Hi {$name},</p><p>According to our records, you are 
                    currently renting the bike with plate number <b>
                    {$plateNumber}</b>, which is now due for maintenance. If this 
                    is not the correct bike please reply directly to this email 
                    and let us know. Otherwise, please click on the link below 
                    to schedule a service appointment.</p><p>Best regards,</p>
                    <p>Saigon Bike Rentals</p><p><a href='{$link}'><button style='width: 100%; color: #fff; background: blue; padding: 20px; 
                    font-size: 2em; text-align: center; text-shadow: 1px 1px 1px #000; border-radius: 10px; 
                    background-image: linear-gradient(to top left,
                                    rgba(0, 0, 0, .2),
                                    rgba(0, 0, 0, .2) 30%,
                                    rgba(0, 0, 0, 0)); box-shadow: inset 2px 2px 3px rgba(255, 255, 255, .6),
                    inset -2px -2px 3px rgba(0, 0, 0, .6);'>Click Here to Book Appointment</button></a></p>
                    <br><p><strong>PS - PLEASE DISREGARD IF YOU HAVE ALREADY BOOKED AN APPOINTMENT OR ARE UNAVAILABLE</strong?</p>
                    <br><p><strong>PPS - IF YOUR PHONE USES iOS WHEN YOUR APPOINTMENT
                    INFO DISPLAYS (AFTER BOOKING) THE TEXT WILL BE NEARLY INVISIBLE -SORRY!</strong?</p>";

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

  public function addPhotoPaths()
  {
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

    // $db = db_connect();

    return $this->db->query($sql);
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

  public function addedToGarage()
  {
    $model = new InventoryChangesModel;

    $sql = 'SELECT plate_number, 
                  (SELECT MAX(date) FROM parked_in_garage 
                      WHERE date < (SELECT MAX(date) FROM parked_in_garage)) AS period_start,
                  (SELECT MAX(date) FROM parked_in_garage) AS period_end
                    FROM bikes
                    WHERE plate_number 
                    IN (
                        SELECT plate_number
                        FROM parked_in_garage
                        WHERE date = (SELECT MAX(date) FROM parked_in_garage)
                    )
                    AND plate_number
                    NOT IN (
                      SELECT plate_number
                          FROM parked_in_garage
                          WHERE date = (
                                SELECT MAX(date) 
                                FROM parked_in_garage
                                WHERE date < (
                                  SELECT MAX(date)
                                    FROM parked_in_garage
                                )
                            )
                    )';

    $bikesAdded = $this->db->query($sql)->getResultArray();

    foreach ($bikesAdded as $bike) {
      $inventoryChange = new InventoryChange;
      $inventoryChange->plate_number = $bike['plate_number'];
      $inventoryChange->period_start = $bike['period_start'];
      $inventoryChange->period_end = $bike['period_end'];
      $inventoryChange->bike_in = 1;
      $model->insert($inventoryChange);
    }
  }

  public function removedFromGarage()
  {
    $model = new InventoryChangesModel;

    $sql = 'SELECT plate_number, 
        (SELECT MAX(date) FROM parked_in_garage 
              WHERE date < (SELECT MAX(date) FROM parked_in_garage)) AS period_start,
        (SELECT MAX(date) FROM parked_in_garage) AS period_end
          FROM bikes
          WHERE plate_number 
          NOT IN (
              SELECT plate_number
              FROM parked_in_garage
              WHERE date = (SELECT MAX(date) FROM parked_in_garage)
          )
          AND plate_number
          IN (
            SELECT plate_number
                FROM parked_in_garage
                WHERE date = (
                      SELECT MAX(date) 
                      FROM parked_in_garage
                      WHERE date < (
                        SELECT MAX(date)
                          FROM parked_in_garage
                      )
                  )
          )';

    $bikesRemoved = $this->db->query($sql)->getResultArray();

    foreach ($bikesRemoved as $bike) {
      $inventoryChange = new InventoryChange;
      $inventoryChange->plate_number = $bike['plate_number'];
      $inventoryChange->period_start = $bike['period_start'];
      $inventoryChange->period_end = $bike['period_end'];
      $inventoryChange->bike_out = 1;
      $model->insert($inventoryChange);
    }
  }

  public function updateInventoryChanges()
  {
    if (is_cli()) {
      // This will check first that the newest date in `parked_in_garage`
      // is greater than the highest value for `period_end` in `inventory_changes`
      // if yes, it will call `addedToGarage` and then `removedFromGarage`
      $sql1 = 'SELECT MAX(date) AS date FROM parked_in_garage';
      $sql2 = 'SELECT MAX(period_end) AS date FROM inventory_changes';

      $maxParkedInGarage = $this->db->query($sql1)->getResultArray();
      $maxInventoryChange = $this->db->query($sql2)->getResultArray();

      if (!(($maxParkedInGarage[0]['date'] == $maxInventoryChange[0]['date']))) {
        $this->addedToGarage();
        $this->removedFromGarage();
      }
    }
  }
}
