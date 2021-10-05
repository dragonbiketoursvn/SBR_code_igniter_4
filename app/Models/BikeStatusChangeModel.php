<?php

namespace App\Models;

class BikeStatusChangeModel extends \CodeIgniter\Model
{
  protected $table = 'bike_status_change';

  protected $allowedFields = ['plate_number', 'user', 'date_time', 'new_status', 'customer_id'];

  protected $returnType = 'App\Entities\BikeStatusChange';

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

  public function getCurrentStatus($contract_number){
    
    return $this->where('customer_id', $contract_number)
                ->first();

  }

}
