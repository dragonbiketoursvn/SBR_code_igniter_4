<?php

namespace App\Models;

class testNoAutoIncrementModel extends \CodeIgniter\Model
{
  protected $table = 'test_no_auto_increment';
  protected $primaryKey = 'id';

  protected $allowedFields = [
      'id', 'name', 
  ];

  protected $returnType = 'App\Entities\testNoAutoIncrement';

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
