<?php

namespace App\Models;

class XR150PartsPurchaseModel extends \CodeIgniter\Model
{
  protected $table = 'xr_150_parts_purchases';

  protected $allowedFields = [
    'supplier_id',
    'part_code',
    'price_vnd',
    'price_usd',
    'date',
    'quantity'
  ];

  protected $returnType = 'App\Entities\XR150PartsPurchase';

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

  public function getAll()
  {
    return $this->findAll();
  }
}
