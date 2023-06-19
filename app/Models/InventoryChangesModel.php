<?php

namespace App\Models;

class InventoryChangesModel extends \CodeIgniter\Model
{
  protected $table = 'inventory_changes';

  protected $allowedFields = ['plate_number', 'bike_in', 'bike_out', 'period_start', 'period_end'];

  protected $returnType = 'App\Entities\InventoryChange';

  protected $useTimestamps = false;

  protected $validationRules = [
    'plate_number' => 'required',
    'period_start' => 'required',
    'period_end' => 'required',
  ];

  protected $validationMessages = [];

  protected $beforeUpdate = ['trimWhiteSpace'];
  protected $beforeInsert = ['trimWhiteSpace'];

  protected function trimWhiteSpace($data)
  {
    array_walk($data['data'], function (&$item) {

      $item = trim($item);
    });

    return $data;
  }

  public function getAll()
  {
    return $this->findAll();
  }
}
