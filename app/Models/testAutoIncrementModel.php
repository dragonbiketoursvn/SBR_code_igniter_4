<?php

namespace App\Models;

class testAutoIncrementModel extends \CodeIgniter\Model
{
  protected $table = 'test_auto_increment';

  protected $allowedFields = [
    'name',
  ];

  protected $returnType = 'App\Entities\testAutoIncrement';

  protected $useTimestamps = false;

  protected $validationRules = [
    
  ];

  protected $validationMessages = [
 
  ];

  protected $beforeUpdate = ['trimWhiteSpace'];
  protected $beforeInsert = ['trimWhiteSpace'];

  protected function trimWhiteSpace($data)
  {
    array_walk($data['data'], function (&$item) {

      $item = trim($item);
    });

    return $data;
  }
}
