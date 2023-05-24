<?php

namespace App\Models;

use App\Libraries\Token;

class CustomersModel extends \CodeIgniter\Model
{
  protected $table = 'customers';

  protected $allowedFields = [
    'customer_name', 'nationality', 'male', 'email_address', 'primary_contact_channel', 'email_confirmed', 'phone_number', 'employer',
    'found_via', 'currently_renting', 'start_date', 'deposit_type', 'current_bike', 'rent',
    'finish_date', 'notes', 'building_name', 'building_number', 'street_name', 'ward', 'district', 'city',
    'passport_photo', 'license_photo', 'dragon_bikes', 'activation_hash', 'is_active', 'passport', 'TRC_or_visa',
    'license_front', 'license_back'
  ];

  protected $returnType = 'App\Entities\Customer';

  protected $useTimestamps = false;

  protected $validationRules = [
    'customer_name' => 'required',
    'email_address' => 'required|valid_email',
    'current_bike'  => 'required',
    'rent' => 'required|greater_than[100]|less_than[20000]',
    'district' => 'required',
  ];

  protected $validationMessages = [
    'customer_name' => 'Please enter a name',
    'email_address' => 'Please enter a valid email address',
    'current_bike'  => 'Please enter the plate number',
    'rent' => 'Please enter a valid rental amount',
    'street_name' => 'Please enter the name of the street',
    'district' => 'Please enter the name of the district',
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

  public function getCurrentCustomers()
  {
    return $this->where('currently_renting', 1)
      ->findAll();
  }

  public function getAllCustomers()
  {
    return $this->orderBy('start_date', 'DESC')->findAll();
  }

  public function getCurrentCustomerByName($name)
  {

    return $this->where('customer_name', $name)
      ->where('currently_renting', 1)
      ->first();
  }

  public function activateByToken($token)
  {

    $token = new Token($token);

    $token_hash = $token->getHash();

    $customer = $this->where('activation_hash', $token_hash)
      ->first();

    if ($customer !== null) {

      $customer->activate();
      $this->save($customer);
      return $customer;
    }
  }

  public function getTodaysStartRecords()
  {
    $yesterday = date('Y-m-d', time() - 24 * 3600) . ' 23:59:59';;

    return $this->where('start_date >', $yesterday)
      ->findAll();
  }

  public function getTodaysEndRecords()
  {
    $yesterday = date('Y-m-d', time() - 24 * 3600) . ' 23:59:59';

    return $this->where('finish_date >', $yesterday)
      ->findAll();
  }
}
