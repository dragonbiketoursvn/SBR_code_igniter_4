<?php

namespace App\Models;

class MoneyToStaffModel extends \CodeIgniter\Model
{
  protected $table = 'money_to_staff';

  protected $allowedFields = ['date', 'amount', 'notes'];

  protected $returnType = 'App\Entities\MoneyToStaff';

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
  
}
