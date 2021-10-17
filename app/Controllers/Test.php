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
        return view('Tests/test1');
    }

    public function testTwo()
    {
        $files = $this->request->getFiles();
        
        $pathArray = [];
        
        foreach ($files as $key => $file) {
            if ($file->getSizeByUnit('mb' > 0)) {

                if ( ! $file->isValid()) {
            
                    $error_code = $file->getError();
                    throw new \RuntimeException($file->getErrorString() . " " . $error_code);

                }

                $size = $file->getSizeByUnit('mb');
        
                if ($size > 5) {
                    
                    return redirect()->back()
                                     ->with('warning', 'File too large (max 5MB)');

                }
                
                $type = $file->getMimeType();
                
                if ( ! in_array($type, ['image/png', 'image/jpeg'])) {
                    
                    return redirect()->back()
                                    ->with('warning', 'Invalid file format (PNG or JPEG only)');
                }

                $newFileName = $file->getRandomName();
                $path = FCPATH . 'uploads/' . $key .  '/' . $newFileName;

                service('image')
                    ->withFile($file->getTempName())
                    ->fit(800, 400, 'center')
                    ->save($path);

                $path = site_url('uploads/' . $key .  '/' . $newFileName);
                
                $pathArray[] = $path;
            }
        }
       
        
        // $file = $this->request->getFile('image');
        
        // if ( ! $file->isValid()) {
            
        //     $error_code = $file->getError();
            
        //     if ($error_code == UPLOAD_ERR_NO_FILE) {
                
        //         return redirect()->back()
        //                          ->with('warning', 'No file selected');
        //     }
            
        //     throw new \RuntimeException($file->getErrorString() . " " . $error_code);
        // }
        
        // $size = $file->getSizeByUnit('mb');
        
        // if ($size > 5) {
            
        //     return redirect()->back()
        //                      ->with('warning', 'File too large (max 5MB)');
        // }
        
        // $type = $file->getMimeType();
        
        // if ( ! in_array($type, ['image/png', 'image/jpeg'])) {
            
        //     return redirect()->back()
        //                      ->with('warning', 'Invalid file format (PNG or JPEG only)');
        // }
        
        // $path = FCPATH . 'uploads/profile_images/' . $file->getName();
        // $pathLoRes = FCPATH . 'uploads/profile_images/lo_res/' . $file->getName();

        // service('image')
        //     ->withFile($file->getTempName())
        //     ->fit(800, 400, 'center')
        //     ->save($path);

        // service('image')
        //     ->withFile($file->getTempName())
        //     ->fit(800, 800, 'center')
        //     ->save($pathLoRes, 10);
        
        // $path = site_url('uploads/profile_images/lo_res/' . $file->getName());

        // Get 2nd uploaded image and process before saving
        // $file2 = $this->request->getFile('image2');
        
        // if ( ! $file2->isValid()) {
            
        //     $error_code = $file2->getError();
            
        //     throw new \RuntimeException($file2->getErrorString() . " " . $error_code);
        // }
        
        // $size = $file2->getSizeByUnit('mb');
        
        // if ($size > 5) {
            
        //     return redirect()->back()
        //                      ->with('warning', 'File too large (max 2MB)');
        // }
        
        // $type2 = $file2->getMimeType();
        
        // if ( ! in_array($type2, ['image/png', 'image/jpeg'])) {
            
        //     return redirect()->back()
        //                      ->with('warning', 'Invalid file format (PNG or JPEG only)');
        // }
        
        // $path2 = FCPATH . 'uploads/second_images/' . $file2->getName();

        // service('image')
        //     ->withFile($file2->getTempName())
        //     ->fit(800, 800, 'center')
        //     ->save($path2);
        
        // $path2 = site_url('uploads/second_images/' . $file2->getName());

        return view('Tests/test2.php', ['pathArray' => $pathArray]);
    }

    public function emailSelf()
    {
        if(is_cli())
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
}

