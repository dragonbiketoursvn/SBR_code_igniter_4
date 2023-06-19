<?php

namespace App\Controllers\Admin;

use App\Entities\InventoryChange;

class Customers extends \App\Controllers\BaseController
{
  private $model;

  public function __construct()
  {
    $this->model = new \App\Models\InventoryChangesModel;
  }
}
