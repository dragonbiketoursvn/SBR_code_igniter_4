<?php

namespace App\Models;

class XR150PartsInventoryModel extends \CodeIgniter\Model
{
  protected $table = 'xr_150_parts_inventory';

  protected $allowedFields = [
    'part_code',
    'quantity',
    'date'
  ];

  protected $returnType = 'App\Entities\XR150PartInventoryRecord';

  protected $useTimestamps = false;

  protected $validationRules = [];
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

  public function getCurrent()
  {
    $date = $this->selectMax('date')->first()->date;

    return $this->where('date', $date)
      ->findAll();
  }

  public function getAll()
  {
    return $this->findAll();
  }
}
