<?php

namespace App\Models;

class SuppliersModel extends \CodeIgniter\Model
{
  protected $table = 'suppliers';

  protected $allowedFields = [
    'name',
    'location',
  ];

  protected $returnType = 'App\Entities\Supplier';

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

  public function getByName($name)
  {
    return $this->where('name', $name)
      ->first();
  }

  public function getAll()
  {
    return $this->findAll();
  }
}
