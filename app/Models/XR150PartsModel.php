<?php

namespace App\Models;

class XR150PartsModel extends \CodeIgniter\Model
{
  protected $table = 'xr_150_parts';

  protected $allowedFields = [
    'code',
    'name',
    'image'
  ];

  protected $returnType = 'App\Entities\XR150Part';

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

  public function getByCode($code)
  {
    return $this->where('code', $code)
      ->first();
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
