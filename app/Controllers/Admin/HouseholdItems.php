<?php

namespace App\Controllers\Admin;

use App\Entities\HouseholdItem;
use App\Models\HouseholdItemsModel;

class HouseholdItems extends \App\Controllers\BaseController
{
  private $model;

  public function __construct()
  {
    $this->model = new \App\Models\HouseholdItemsModel();
  }

  public function selectView()
  {
    return view('Admin/HouseholdItems/selectView');
  }

  public function viewAll()
  {
    $items = $this->model->getAll();

    return view('Admin/HouseholdItems/viewAll', [
      'items' => $items
    ]);
  }

  public function addRecord()
  {
    $viewVariables = [];
    if (session()->has('success')) {
      $viewVariables['success'] = 'Record successfully added!';
    }

    return view('Admin/HouseholdItems/addRecord', $viewVariables);
  }

  public function saveRecord()
  {
    $householdItem = new HouseholdItem;
    $householdItem->fill($this->request->getPost());

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

        if (!in_array($type, ['image/png', 'image/jpeg', 'image/webp'])) {

          return redirect()->back()
            ->with('warning', 'Invalid file format (WEBP, PNG or JPEG only)');
        }

        // Store it in the correct folder
        $file->store('householditem_photos/');

        // Add path to correct bike entity property
        $householdItem->$key = $file->getName();
      }
    }

    // Redirect to addRecord controller if insertion is successful
    $returnID = $this->model->insert($householdItem);

    if ($this->model->find($returnID) !== null) {

      session()->setFlashData('success', 'success');

      return redirect()->to(site_url('Admin/HouseholdItems/addRecord'));
    } else {

      return redirect()->back()->with('errors', $this->model->errors())->withInput();
    }
  }

  // public function updateRecord()
  // {
  //   $bike = new Bike;
  //   $bike->fill($this->request->getPost());

  //   // Get all the uploaded files
  //   $files = $this->request->getFiles();

  //   //LOOP THROUGH THE FILES ARRAY, GETTING THE KEY FOR EACH INDEX SO WE CAN USE IT TO CREATE THE CORRECT FOLDER FOR EACH UPLOADED FILE
  //   foreach ($files as $key => $file) {

  //     // ALL INPUTS ARE NOT REQUIRED SO WE CHECK THAT FILE SIZE IS GREATER THAN ZERO TO DETERMINE WHETHER THERE'S ACTUALLY A FILE AT EACH INDEX
  //     if ($file->getSizeByUnit('mb') > 0) {

  //       // CHECK VALIDITY
  //       if (!$file->isValid()) {
  //         $error_code = $file->getError();
  //         throw new \RuntimeException($file->getErrorString() . " " . $error_code);
  //       }

  //       // CHECK FILE SIZE TO MAKE SURE IT DOESN'T EXCEED OUR MAX ALLOWED SIZE
  //       $size = $file->getSizeByUnit('mb');

  //       if ($size > 5) {

  //         return redirect()->back()
  //           ->with('warning', 'File too large (max 5MB)');
  //       }

  //       $type = $file->getMimeType();

  //       if (!in_array($type, ['image/png', 'image/jpeg', 'image/webp'])) {

  //         return redirect()->back()
  //           ->with('warning', 'Invalid file format (PNG, WEBP, or JPEG only)');
  //       }

  //       // Store it in the correct folder
  //       if (($key == 'reg_front') || ($key == 'reg_back')) {

  //         $file->store('registration_cards/');
  //       } else {

  //         $file->store('bike_photos/');
  //       }
  //       // Add path to correct bike entity property
  //       $bike->$key = $file->getName();
  //     }
  //   }

  //   // Redirect to addRecord controller if insertion is successful
  //   $this->model->save($bike);

  //   if ($this->model->find($bike->plate_number) !== null) {
  //     // We're going to pass this data to the view so it redisplays the updated record on loading
  //     session()->setFlashData('plate_number', $bike->plate_number);
  //     return redirect()->to(site_url('Admin/Bikes/viewIndividual'));
  //   } else {

  //     return redirect()->back()->with('errors', $this->model->errors())->withInput();
  //   }
  // }

  // public function showProfile()
  // {
  //   $plateNumber = $this->request->getPost('plate_number');
  //   $bike = $this->model->getBikeByPlateNumber($plateNumber);

  //   // we'd like to have the bike's current status as well...
  //   $bikeStatusChangeModel = new BikeStatusChangeModel;
  //   $currentStatus = $bikeStatusChangeModel->getCurrentStatusByPlateNumber($plateNumber);
  //   $bike->current_status = $currentStatus->new_status ?? "Saigon Bike Rentals";

  //   return ($this->response->setJSON($bike));
  // }

  // Displays reg photo at $path if it exists
  public function displayPhoto($path)
  {
    $path = WRITEPATH . 'uploads/householditem_photos/' . $path;

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

  // // Displays bike photo at $path if it exists
  // public function displayBikePhoto($path)
  // {
  //   $path = WRITEPATH . 'uploads/bike_photos/' . $path;

  //   // Since we don't erase the $bike->path property when deleting images from the server we need to check if there's still
  //   // a file located at $path
  //   if (is_file($path)) {

  //     $finfo = new \finfo(FILEINFO_MIME);

  //     $type = $finfo->file($path);

  //     header("Content-Type: $type");
  //     header("Content-Length: " . filesize($path));

  //     readfile($path);
  //   }

  //   exit;
  // }

  // Deletes photo from writable directory if it exists
  public function deletePhoto($path)
  {
    $path = WRITEPATH . 'uploads/householditem_photos/' . $path;

    if (is_file($path)) {
      unlink($path);
    }
  }

  // // Deletes photo from writable directory if it exists
  // public function deleteBikePhoto($path)
  // {
  //   $path = WRITEPATH . 'uploads/bike_photos/' . $path;

  //   if (is_file($path)) {
  //     unlink($path);
  //   }
  // }

  // public function viewAll()
  // {
  //   $bikes = $this->model->getCurrentBikes();
  //   $models = $this->model->getCurrentModels();
  //   $customers = $this->customersModel->getCurrentCustomers();

  //   return view('Admin/Bikes/viewAll', [
  //     'bikes' => $bikes,
  //     'models' => $models,
  //     'customers' => $customers,
  //   ]);
  // }

  // public function viewData()
  // {
  //   $currentBikes = $this->model->getCurrentBikes();
  //   $bikesMoneyOwed = $this->model->getBikesOwedMoney();

  //   $models = $this->model->getCurrentModels();
  //   $customers = $this->customersModel->getCurrentCustomers();
  //   dd('cock');
  //   // return view('Admin/Bikes/viewAll', [
  //   //   'bikes' => $bikes,
  //   //   'models' => $models,
  //   //   'customers' => $customers,
  //   // ]);
  // }
}
