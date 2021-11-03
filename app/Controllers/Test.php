<?php

namespace App\Controllers;

use App\Models\BikesModel;
use App\Libraries\Token;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Test extends BaseController
{

  public function testOne()
	{
    return view('Tests/testOne.php');
  }

 
  public function testTwo()
  { 
    $path = $this->request->getFile('photo')->store('images/');
    $path = WRITEPATH . 'uploads/' . $path;
    
    return view('Tests/testTwo', ['path' => str_replace('/', '\/', $path)]);
  }

  public function showImage($path)
  {      
    $path = str_replace('\\/', '/', $path);

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
      $mail->addAttachment(WRITEPATH . 'images/1635835163_27218a1fdb467e958310.png');    
      
      if (!$mail->send()) {

          echo 'Mailer Error: ' . $mail->ErrorInfo;

      } 
    }
}
