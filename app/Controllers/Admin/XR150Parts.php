<?php

namespace App\Controllers\Admin;

use App\Entities\XR150Part;
use App\Entities\XR150PartsPurchase;
use App\Entities\Supplier;

class XR150Parts extends \App\Controllers\BaseController
{
  private $XR150PartsModel;
  private $XR150PartsPurchaseModel;
  private $SuppliersModel;

  public function __construct()
  {
    $this->XR150PartsModel = new \App\Models\XR150PartsModel;
    $this->XR150PartsPurchaseModel = new \App\Models\XR150PartsPurchaseModel;
    $this->SuppliersModel = new \App\Models\SuppliersModel;
  }

  public function viewMenu()
  {
    return view('Admin/XR150Parts/viewMenu');
  }

  public function newPart()
  {
    $parts = $this->XR150PartsModel->getAll();
    return view('Admin/XR150Parts/newPart', ['parts' => $parts]);
  }

  public function addPart()
  {
    $part = new XR150Part($this->request->getPost());

    // Get all the uploaded files
    $files = $this->request->getFiles();

    //LOOP THROUGH THE FILES ARRAY, GETTING THE KEY FOR EACH INDEX SO WE CAN USE IT TO CREATE THE CORRECT FOLDER FOR EACH UPLOADED FILE
    foreach ($files as $file) {

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

        $file->store('part_images/');

        // Add path to correct bike entity property
        $part->image = $file->getName();
      }
    }

    // Redirect to addRecord controller if insertion is successful
    if ($this->XR150PartsModel->save($part)) {

      session()->setFlashData('success', 'success');

      return redirect()->to(site_url('Admin/XR150Parts/newPart'));
    } else {

      return redirect()->back()->with('errors', $this->XR150PartsModel->errors())->withInput();
    }
  }

  public function newSupplier()
  {
    return view('Admin/XR150Parts/newSupplier');
  }

  public function addSupplier()
  {
    $supplier = new Supplier($this->request->getPost());

    // Redirect to addRecord controller if insertion is successful
    if ($this->SuppliersModel->save($supplier)) {

      session()->setFlashData('success', 'success');

      return redirect()->to(site_url('Admin/XR150Parts/newSupplier'));
    } else {

      return redirect()->back()->with('errors', $this->SuppliersModel->errors())->withInput();
    }
  }

  public function newPurchase()
  {
    $parts = $this->XR150PartsModel->getAll();
    $suppliers = $this->SuppliersModel->getAll();
    return view('Admin/XR150Parts/newPurchase', ['parts' => $parts, 'suppliers' => $suppliers]);
  }

  public function addPurchase()
  {
    $post = $this->request->getPost();
    $partCode = $this->XR150PartsModel->getByName($post['part_name'])->code;
    $supplierId = $this->SuppliersModel->getByName($post['supplier_name'])->id;
    $purchase = new XR150PartsPurchase([
      'supplier_id' => $supplierId,
      'part_code' => $partCode,
      'price_vnd' => $post['price_vnd'],
      'price_usd' => $post['price_usd'],
      'date' => $post['purchase_date'],
      'quantity' => $post['quantity']
    ]);

    // Redirect to addRecord controller if insertion is successful
    if ($this->XR150PartsPurchaseModel->save($purchase)) {

      session()->setFlashData('success', 'success');

      return redirect()->to(site_url('Admin/XR150Parts/newPurchase'));
    } else {

      return redirect()->back()->with('errors', $this->SuppliersModel->errors())->withInput();
    }
  }
}
