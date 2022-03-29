<?php

namespace App\Controllers\Admin;

use PHPMailer\PHPMailer\PHPMailer;

class Photos extends \App\Controllers\BaseController
{
    // Displays photo at $path if it exists
    public function displayPhoto($path)
    {
        $path = WRITEPATH . 'uploads/images/' . $path;

        // Since we don't erase the $bike->path property when deleting images from the server we need to check if there's still
        // a file located at $path
        if (is_file($path)) {

            $finfo = new \finfo(FILEINFO_MIME);

            $type = $finfo->file($path);

            header("Content-Type: $type");
            header("Content-Length: " . filesize($path));

            readfile($path);
        }

        exit;
    }

    // This will be called from various views (in the edit state) to delete photos from 'writable/uploads/images' if they exist
    public function deletePhoto($path)
    {
        $path = WRITEPATH . 'uploads/images/' . $path;

        if (is_file($path)) {
            unlink($path);
        }
    }

    // sends photos as email attachments
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
}
