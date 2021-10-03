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

  public function getCurrentCustomers() {
    return $this->where('currently_renting', 1)
                ->findAll();
  }

  public function getAllCustomers() {
    return $this->findAll();
  }

  public function getNationalities() {
    return $this->select('nationality')
                ->distinct('nationality')
                ->orderBy('nationality')
                ->get()
                ->getResultArray();
  }

  public function getBuildingNames() {
    return $this->select('building_name')
                ->distinct('building_name')
                ->orderBy('building_name')
                ->get()
                ->getResultArray();
  }

  public function getStreetNames() {
    return $this->select('street_name')
                ->distinct('street_name')
                ->orderBy('street_name')
                ->get()
                ->getResultArray();
  }

  public function getWards() {
    return $this->select('ward')
                ->distinct('ward')
                ->orderBy('ward')
                ->get()
                ->getResultArray();
  }

  public function getDistricts() {
    return $this->select('district')
                ->distinct('district')
                ->orderBy('district')
                ->get()
                ->getResultArray();
  }

}
