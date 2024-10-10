<?php

namespace App\Controllers\Admin;

use App\Entities\Bike;
use App\Models\BikeStatusChangeModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Bikes extends \App\Controllers\BaseController
{
  private $model;
  private $customersModel;
  private $compensationTicketsModel;
  private $compensationPaymentsModel;

  public function __construct()
  {
    $this->model = new \App\Models\BikesModel;
    $this->customersModel = new \App\Models\CustomersModel;
    $this->compensationTicketsModel = new \App\Models\CompensationTicketsModel;
    $this->compensationPaymentsModel = new \App\Models\CompensationPaymentsModel;
  }

  public function selectView()
  {
    return view('Admin/Bikes/selectView');
  }

  public function currentInventory()
  {
    return view('Admin/Bikes/currentInventory');
  }

  public function viewIndividual()
  {
    $currentBikes = $this->model->getCurrentBikes();
    $currentModels = $this->model->getCurrentModels();
    $customers = $this->customersModel->getCurrentCustomers();
    $viewVariables = ['currentBikes' => $currentBikes, 'currentModels' => $currentModels, 'customers' => $customers];

    // If a record has just been updated, $_SESSION will have the plate_number as flashdata.
    // If it's there we'll send it to the view together with the other view variables
    if (session()->has('plate_number')) {
      $viewVariables['plateNumber'] = session()->get('plate_number');
    }

    return view('Admin/Bikes/viewIndividual', $viewVariables);
  }

  public function getEmailsAsJSON()
  {
    $customers = $this->customersModel->getCurrentCustomers();
    $customerEmails = [];

    foreach ($customers as $customer) {
      $customerEmails[$customer->customer_name] = $customer->email_address;
    }

    return $this->response->setJSON($customerEmails);
  }

  public function addRecord()
  {
    $currentBikes = $this->model->getCurrentBikes();
    $currentModels = $this->model->getCurrentModels();
    $viewVariables = ['currentBikes' => $currentBikes, 'currentModels' => $currentModels,];

    if (session()->has('success')) {
      $viewVariables['success'] = 'Record successfully added!';
    }

    return view('Admin/Bikes/addRecord', $viewVariables);
  }

  public function saveRecord()
  {
    $bike = new Bike;
    $bike->fill($this->request->getPost());

    // Get all the uploaded files
    $files = $this->request->getFiles();

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

        // Store it in the correct folder
        if (($key == 'reg_front') || ($key == 'reg_back')) {

          $file->store('registration_cards/');
        } else {

          $file->store('bike_photos/');
        }

        // Add path to correct bike entity property
        $bike->$key = $file->getName();
      }
    }

    // Redirect to addRecord controller if insertion is successful
    $this->model->insert($bike);

    if ($this->model->find($bike->plate_number) !== null) {

      session()->setFlashData('success', 'success');

      return redirect()->to(site_url('Admin/Bikes/addRecord'));
    } else {

      return redirect()->back()->with('errors', $this->model->errors())->withInput();
    }
  }

  public function updateRecord()
  {
    $bike = new Bike;
    $bike->fill($this->request->getPost());

    // Get all the uploaded files
    $files = $this->request->getFiles();

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

        // Store it in the correct folder
        if (($key == 'reg_front') || ($key == 'reg_back')) {

          $file->store('registration_cards/');
        } else {

          $file->store('bike_photos/');
        }

        // Add path to correct bike entity property
        $bike->$key = $file->getName();
      }
    }

    // Redirect to addRecord controller if insertion is successful
    $this->model->save($bike);

    if ($this->model->find($bike->plate_number) !== null) {
      // We're going to pass this data to the view so it redisplays the updated record on loading
      session()->setFlashData('plate_number', $bike->plate_number);

      return redirect()->to(site_url('Admin/Bikes/viewIndividual'));
    } else {

      return redirect()->back()->with('errors', $this->model->errors())->withInput();
    }
  }

  public function showProfile()
  {
    $plateNumber = $this->request->getPost('plate_number');
    $bike = $this->model->getBikeByPlateNumber($plateNumber);

    // we'd like to have the bike's current status as well...
    $bikeStatusChangeModel = new BikeStatusChangeModel;
    $currentStatus = $bikeStatusChangeModel->getCurrentStatusByPlateNumber($plateNumber);
    $bike->current_status = $currentStatus->new_status ?? "Saigon Bike Rentals";

    return ($this->response->setJSON($bike));
  }

  public function showCompensationOwed()
  {
    $plateNumber = $this->request->getPost('plate_number');
    $compensationTicket = $this->compensationTicketsModel->getActiveTicketsByPlateNumber($plateNumber);
    $customer = $this->customersModel->getCustomerByID($compensationTicket->customer_id);
    $compensationTicket->customer_name = $customer->customer_name;
    $compensationTicket->paidToDate =
      $this->compensationPaymentsModel
        ->getTotalPaidOnTicket($compensationTicket->id)[0]->amount;
    $compensationTicket->amountOutstanding =
      $compensationTicket->cost_incurred - $compensationTicket->paidToDate;

    return ($this->response->setJSON($compensationTicket));
  }

  // Displays reg photo at $path if it exists
  public function displayRegPhoto($path)
  {
    $path = WRITEPATH . 'uploads/registration_cards/' . $path;

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

  // Displays bike photo at $path if it exists
  public function displayBikePhoto($path)
  {
    $path = WRITEPATH . 'uploads/bike_photos/' . $path;

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

  // Deletes photo from writable directory if it exists
  public function deleteRegPhoto($path)
  {
    $path = WRITEPATH . 'uploads/registration_cards/' . $path;

    if (is_file($path)) {
      unlink($path);
    }
  }

  // Deletes photo from writable directory if it exists
  public function deleteBikePhoto($path)
  {
    $path = WRITEPATH . 'uploads/bike_photos/' . $path;

    if (is_file($path)) {
      unlink($path);
    }
  }

  public function mailRegPhotos()
  {
    $length = count($_POST);
    $post = $this->request->getPost();
    $address = $post['address'];
    $message = $post['message'];
    $paths = []; // We'll have between one and two paths so we'll stick them in an array

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
    $mail->Subject = 'Bike Registration';
    $mail->Body = $message;

    foreach ($paths as $path) {

      $filePath = WRITEPATH . 'uploads/registration_cards/' . $path;

      if (is_file($filePath)) {

        $mail->addAttachment($filePath);
      } else {
        return $this->response->setJSON('Files not found');
      }
    }

    if (!$mail->send()) {

      return $this->response->setJSON($mail->ErrorInfo);
    } else {

      return $this->response->setJSON('Success!');
    }
  }

  public function mailBikePhotos()
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
    $mail->Subject = 'Bike Registration';
    $mail->Body = $message;

    foreach ($paths as $path) {

      $filePath = WRITEPATH . 'uploads/bike_photos/' . $path;

      if (is_file($filePath)) {

        $mail->addAttachment($filePath);
      } else {
        return $this->response->setJSON('Files not found');
      }
    }

    if (!$mail->send()) {

      return $this->response->setJSON($mail->ErrorInfo);
    } else {

      return $this->response->setJSON('Success!');
    }
  }

  public function viewAll()
  {
    $bikes = $this->model->getCurrentBikes();
    $models = $this->model->getCurrentModels();
    $customers = $this->customersModel->getCurrentCustomers();

    return view('Admin/Bikes/viewAll', [
      'bikes' => $bikes,
      'models' => $models,
      'customers' => $customers,
    ]);
  }

  public function viewData()
  {
    $currentBikes = $this->model->getCurrentBikes();
    $bikesMoneyOwed = $this->model->getBikesOwedMoney();

    $models = $this->model->getCurrentModels();
    $customers = $this->customersModel->getCurrentCustomers();
    dd('cock');
    // return view('Admin/Bikes/viewAll', [
    //   'bikes' => $bikes,
    //   'models' => $models,
    //   'customers' => $customers,
    // ]);
  }
}
