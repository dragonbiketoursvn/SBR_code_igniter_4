<?php

namespace App\Models;

class ReservationsModel extends \CodeIgniter\Model
{
  protected $table = 'reservations';

  protected $allowedFields = [
    'active', 'model_year_code', 'start_city', 'start_date', 'end_city',
    'end_date', 'customer_name'
  ];

  protected $returnType = 'App\Entities\Reservation';

  // protected $useTimestamps = true;

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

  public function getActiveReservations()
  {
    return $this->where('active', 1)
      ->findAll();
  }
}
