<?php

namespace App\Models;

class CustomersModel extends \CodeIgniter\Model
{
  protected $table = 'customers';

  protected $allowedFields = ['customer_name', 'nationality', 'male', 'email_address', 'email_confirmed', 'phone_number', 'employer',
                              'found_via', 'currently_renting', 'start_date', 'deposit_type', 'current_bike', 'rent',
                              'finish_date', 'notes', 'building_name', 'building_number', 'street_name', 'ward', 'district', 'city',
                              'passport_photo', 'license_photo', 'dragon_bikes'];

  protected $returnType = 'App\Entities\Customer';

  protected $useTimestamps = true;

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
