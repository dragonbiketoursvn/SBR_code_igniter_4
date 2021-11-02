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
    // Create new Test entity and fill with text values from form
    $test = new \App\Entities\Test;
    $test->fill($this->request->getPost());
    
    // Get the file uploaded by the 'photo' input
    $files = $this->request->getFiles();
    
    //LOOP THROUGH THE FILES ARRAY, GETTING THE KEY FOR EACH INDEX SO WE CAN USE IT TO CREATE THE CORRECT FOLDER FOR EACH UPLOADED FILE
    foreach ($files as $key => $file) {

      // ALL INPUTS ARE NOT REQUIRED SO WE CHECK THAT FILE SIZE IS GREATER THAN ZERO TO DETERMINE WHETHER THERE'S ACTUALLY A FILE AT EACH INDEX
      if ($file->getSizeByUnit('mb' > 0)) {

          // CHECK VALIDITY
          if ( ! $file->isValid()) {

              $error_code = $file->getError();
              throw new \RuntimeException($file->getErrorString() . " " . $error_code);

          }

          // CHECK FILE SIZE TO MAKE SURE IT DOESN'T EXCEED OUR MAX ALLOWED SIZE
          $size = $file->getSizeByUnit('mb');

          if ($size > 5) {

              return redirect()->back()
                               ->with('warning', 'File too large (max 5MB)');

          }

          // GET MIME TYPE AND CHECK IF IT'S ALLOWED
          $type = $file->getMimeType();

          if ( ! in_array($type, ['image/png', 'image/jpeg'])) {

              return redirect()->back()
                              ->with('warning', 'Invalid file format (PNG or JPEG only)');
          }

          $type = $file->getMimeType();

          if ( ! in_array($type, ['image/png', 'image/jpeg'])) {

              return redirect()->back()
                              ->with('warning', 'Invalid file format (PNG or JPEG only)');
          }

          // Store it in the 'writable/uploads/images' folder
          $file->store('images/');

          // Add path to correct entity property
          $test->$key = $file->getName(); 
      }       
  }
  
    $model = new \App\Models\TestModel;
    $model->save($test);
    
    return view('Tests/testTwo');

  }

  public function showImage($path)
  {      
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
      $mail->addAttachment(WRITEPATH . 'uploads/profile_images/1635835163_27218a1fdb467e958310.png');    

      if (!$mail->send()) {

          echo 'Mailer Error: ' . $mail->ErrorInfo;

      } 
    }
}
