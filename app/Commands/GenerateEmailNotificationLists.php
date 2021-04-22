<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\AppointmentsModel;
use App\Entities\Appointment;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class GenerateEmailNotificationLists extends BaseCommand
{
    protected $group       = 'Renters';
    protected $name        = 'renters:scheduleAppointments';
    protected $description = 'Emails renters to schedule appointments.';

    public function run(array $params)
    {
        //THIS IS WHERE WE WILL HAVE DATABASE QUERY TO GENEREATE NOTIFICATION LISTS BASED ON WHAT NEEDS TO BE DONE (RENT/SERVICE)

        $db = db_connect();
        $sql = 'SELECT contract_number, customer_name, email_address, DATE_ADD(start_date, INTERVAL months_paid MONTH) AS paid_up_to, current_bike,
        (SELECT repair_date FROM repairs WHERE nhot = 1 AND plate_number = a.current_bike ORDER BY repair_date DESC LIMIT 1) AS last_oil_change,
        (SELECT total_cost FROM repairs WHERE nhot = 1 AND plate_number = a.current_bike ORDER BY repair_date DESC LIMIT 1) AS last_repair_total
        FROM (SELECT contract_number, customer_name, email_address, start_date, (SELECT SUM(months_paid) FROM payments
        WHERE contract_number = c.contract_number) AS months_paid, (SELECT plate_number FROM bike_status_change
        WHERE contract_number = c.contract_number ORDER BY date_time DESC LIMIT 1) AS current_bike
        FROM customers c WHERE currently_renting = 1)a ORDER BY paid_up_to DESC';

        $result = $db->query($sql);

        $twoMonthsAgo = date('Y-m-d', time() - 60 * 24 *3600);
        $threeMonthsAgo = date('Y-m-d', time() - 90 * 24 *3600);

        $model = new AppointmentsModel;

        foreach ($result->getResultArray() as $row) {

          $appointment = new Appointment($row);

          $message = "Hi there " . $appointment->customer_name . ", \n";

          if($row['paid_up_to'] < $twoMonthsAgo) {

            $appointment->pay_rent = 1;

          }

          if(($row['last_oil_change'] < $threeMonthsAgo) && ($row['last_repair_total']) < 800) {

            $appointment->full_service = 1;
            //$message5 = 'It will just be a quick service so we can return it to you in 30 minutes to an hour.';

          }

          if(($row['last_oil_change'] < $threeMonthsAgo) && ($row['last_repair_total']) > 800) {

            $appointment->small_service = 1;
            //$message4 = "The bike needs a full service so we'll give you another to use until that one's ready.";

          }

          if(($appointment->pay_rent == 1) && (($appointment->full_service == 1) || ($appointment->small_service == 1))) {

            $message .= "We need to collect rent and service the bike. \n";

          }

          if(($appointment->pay_rent == 1) && (($appointment->full_service == 0) && ($appointment->small_service == 0))) {

            $message .= "We need to collect rent. \n";

          }
          if(($appointment->pay_rent == 0) && (($appointment->full_service == 1) || ($appointment->small_service == 1))) {

            $message .= "We need to service the bike. \n";

          }
          if($appointment->full_service == 1) {

            $message .= "It needs a full service so we'll give you another to use until that one's ready. \n";

          }
          if($appointment->full_service == 0) {

            $message .= "It will just be a quick service so we can return it to you in 30 minutes to an hour. \n";

          }

          /*


          $appointment->pay_rent = 0;





          if(($appointment->pay_rent = 1) && (($appointment->full_service = 0) && ($appointment->small_service = 0))) {

            $message .= 'collect rent';

          }

          if(($appointment->pay_rent = 0) && (($appointment->full_service = 0) || ($appointment->small_service = 0))) {

            $message .= 'service the bike';

          }

          if(($appointment->pay_rent = 1) && (($appointment->full_service = 1) || ($appointment->small_service = 1))) {

            $message .= 'collect rent and service the bike';

          }

          echo $appointment->customer_name . ' pay rent = ' . $appointment->pay_rent . "\n";
          echo $row['paid_up_to'] . "\n";
          echo $twoMonthsAgo . "\n";
          */

          $model->insert($appointment);
          echo $message;
        }

        //THIS IS JUST AN EXAMPLE EMAIL ARRAY
        $addressArray = ['dragonbiketoursvn@gmail.com', 'nga.natalie@gmail.com'];

        require ROOTPATH . '/vendor/PHPMailer-master/src/Exception.php';
        require ROOTPATH . '/vendor/PHPMailer-master/src/PHPMailer.php';
        require ROOTPATH . '/vendor/PHPMailer-master/src/SMTP.php';


        //JUST ITERATING THROUGH MY EXAMPLE ARRAY HERE. WHEN DEPLOYED LIVE WE WILL ITERATE THROUGH 5 DIFFERENT LISTS
        foreach($addressArray as $address) {

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
          $mail->Subject = 'New email address';
          $mail->Body = '<h1 style="text-align:center;">SAIGON BIKE RENTALS</h1><div><p>We love you!</p></div>';

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
