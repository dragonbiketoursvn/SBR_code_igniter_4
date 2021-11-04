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
      $db = db_connect();
      $path = WRITEPATH . 'uploads/registration_cards';
      $fileNameArray = scandir($path);
      $model = new \App\Models\BikesModel;
      $bikeArray = $model->getAllBikes();
      
      // Iterate over all the bike records in the array
      foreach ($bikeArray as $bike) {

        // For each bike record get the names of the matching image files from the fileName array
          foreach ($fileNameArray as $row) {

              // Get the paths for the front and back of each reg and update the bike entity properties
              if(preg_match("/{$bike->plate_number}/i", $row)) {
                  if(preg_match("/back/i", $row)) {
                      $bike->reg_back = $row;
                  } else {
                      $bike->reg_front = $row;                                        
                  }
              }
          }

          // We can't use CodeIgniter's model functions since the primary key isn't explictly named 'id'
          // So, we'll have to create and run our own query
          $sql = "UPDATE bikes SET reg_front = '{$bike->reg_front}', reg_back = '{$bike->reg_back}' WHERE plate_number = '{$bike->plate_number}'";
          $db->simpleQuery($sql);
          
      }
    }
}

