<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\RememberedLoginModel;

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

        //$db = db_connect();
        //$sql = 'SELECT * FROM customers LIMIT 3';
        //$result = $db->query($sql);

        //foreach ($result->getResult() as $row) {
        	//echo $row->contract_number;
        	//echo $row->customer_name;
        	//echo $row->email_address;
        //}

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
