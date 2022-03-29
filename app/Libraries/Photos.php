<?php

namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;

// A class to deal with saving, deleting, displaying, and attaching photo files from 'writable/uploads/images'
class Photos /* extends \App\Controllers\BaseController */
{
    // This will be called from the various controller's record save methods to save any uploaded .jpg/.png files and return an entity
    // with the correct file paths added
    public function savePhoto($record, $files)
    {
        //LOOP THROUGH THE FILES ARRAY, GETTING THE KEY FOR EACH INDEX SO WE CAN USE IT TO CREATE THE CORRECT FOLDER FOR EACH UPLOADED FILE
        foreach ($files as $key => $file) {

            // ALL INPUTS ARE NOT REQUIRED SO WE CHECK THAT FILE SIZE IS GREATER THAN ZERO TO DETERMINE WHETHER THERE'S ACTUALLY A FILE AT EACH INDEX
            if ($file->getSizeByUnit('mb' > 0)) {

                // CHECK VALIDITY
                if (!$file->isValid()) {

                    $error_code = $file->getError();
                    throw new \RuntimeException($file->getErrorString() . " " . $error_code);
                }

                // CHECK FILE SIZE TO MAKE SURE IT DOESN'T EXCEED OUR MAX ALLOWED SIZE
                $size = $file->getSizeByUnit('mb');

                if ($size > 5) {

                    return redirect()->back()
                        ->with('warning', 'File too large (max 5MB)');
                }

                $type = $file->getMimeType();

                if (!in_array($type, ['image/png', 'image/jpeg'])) {

                    return redirect()->back()
                        ->with('warning', 'Invalid file format (PNG or JPEG only)');
                }

                $file->store('images/');

                // Add path to correct entity property and return it
                $record->$key = $file->getName();
            }
        }
        return $record;
    }

    // This will be called from various views (in the edit state) to delete photos from 'writable/uploads/images' if they exist
    public function deletePhoto($path)
    {
        $path = WRITEPATH . 'uploads/images/' . $path;

        if (is_file($path)) {
            unlink($path);
        }
    }

    // will be called from views to display photo at $path (if it exists)
    public function displayPhoto($path)
    {
        $path = WRITEPATH . 'uploads/images/' . $path;

        // Since we don't erase the $bike->path property when deleting images from the server we need to check if there's still
        // a file located at $path
        if (is_file($path)) {

            $response = service('response');
            return $response->download($path, null);
        }
    }

    // sends photos as email attachments
    public function mailPhotos($address, $message, $paths)
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
        $mail->addAddress($address);
        $mail->isHTML(true);
        $mail->Subject = 'Pics';
        $mail->Body = $message;

        $response = service('response');

        foreach ($paths as $path) {

            $filePath = WRITEPATH . 'uploads/images/' . $path;

            if (is_file($filePath)) {

                $mail->addAttachment($filePath);
            } else {
                return $response->setJSON('Files not found');
            }
        }

        if (!$mail->send()) {

            return $response->setJSON($mail->ErrorInfo);
        } else {

            return $response->setJSON('Success!');
        }
    }

    // public function mailRegPhotos($address, $message, $paths)
    // {
    //     require ROOTPATH . '/vendor/PHPMailer-master/src/Exception.php';
    //     require ROOTPATH . '/vendor/PHPMailer-master/src/PHPMailer.php';
    //     require ROOTPATH . '/vendor/PHPMailer-master/src/SMTP.php';

    //     $mail = new PHPMailer(true);
    //     $mail->isSMTP();
    //     $mail->Host = 'mail.saigonbikerentals.com';
    //     $mail->SMTPAuth = true;
    //     $mail->Username = 'patrick@saigonbikerentals.com';
    //     $mail->Password = 'n1FaZ!Sz#)vB';
    //     $mail->SMTPSecure = 'tls';
    //     $mail->Port = 26;
    //     $mail->setFrom('patrick@saigonbikerentals.com');
    //     $mail->addAddress($address);
    //     $mail->isHTML(true);
    //     $mail->Subject = 'Bike Registration';
    //     $mail->Body = $message;

    //     foreach ($paths as $path) {

    //         $filePath = WRITEPATH . 'uploads/images/' . $path;

    //         if (is_file($filePath)) {

    //             $mail->addAttachment($filePath);
    //         } else {
    //             return $this->response->setJSON('Files not found');
    //         }
    //     }

    //     if (!$mail->send()) {

    //         return $this->response->setJSON($mail->ErrorInfo);
    //     } else {

    //         return $this->response->setJSON('Success!');
    //     }
    // }
}
