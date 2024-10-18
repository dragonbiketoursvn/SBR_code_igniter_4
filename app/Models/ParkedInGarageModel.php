<?php

namespace App\Models;

class ParkedInGarageModel extends \CodeIgniter\Model
{
  protected $table = 'parked_in_garage';

  protected $allowedFields = ['plate_number', 'date', 'location'];

  protected $returnType = 'App\Entities\ParkingRecord';

  protected $useTimestamps = false;

  protected $validationRules = [
    'plate_number' => 'required',
    'date' => 'required',
  ];

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

  public function getCurrent()
  {
    return $this
      ->selectMax('date')
      ->groupBy('plate_number')
      ->findAll();
  }
}
