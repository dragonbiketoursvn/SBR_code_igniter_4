<?php namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailSelf extends BaseCommand
{
    protected $group       = 'CrontTest';
    protected $name        = 'cronTest:emailSelf';
    protected $description = 'Emails me every hour to demonstrate cron job use.';

    public function run(array $params)
    {
        require ROOTPATH . '/vendor/PHPMailer-master/src/Exception.php';
        require ROOTPATH . '/vendor/PHPMailer-master/src/PHPMailer.php';
        require ROOTPATH . '/vendor/PHPMailer-master/src/SMTP.php';
        //THIS IS WHERE WE WILL HAVE DATABASE QUERY TO GENEREATE NOTIFICATION LISTS BASED ON WHAT NEEDS TO BE DONE (RENT/SERVICE)

        

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
        $mail->Subject = "Greetings from cron jobs!";
        $mail->Body = '<h1>It works!!!</h1>';

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
