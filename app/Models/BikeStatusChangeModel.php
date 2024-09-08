<?php

namespace App\Models;

use DateTime;

class BikeStatusChangeModel extends \CodeIgniter\Model
{
  protected $table = 'bike_status_change';

  protected $allowedFields = ['plate_number', 'user', 'date_time', 'new_status', 'customer_id', 'temporary'];

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

  public function getCurrentStatus($contract_number)
  {

    return $this->where('customer_id', $contract_number)
      ->orderBy('date_time', 'DESC')
      ->first();
  }

  public function getCurrentStatusByPlateNumber($plate_number)
  {
    return $this->where('plate_number', $plate_number)
      ->orderBy('date_time', 'DESC')
      ->first();
  }

  public function getStatusHistoryByPlateNumber($plate_number)
  {
    return $this->where('plate_number', $plate_number)
      ->orderBy('date_time', 'DESC')
      ->findAll();
  }

  public function getTodaysRecords()
  {
    $yesterday = date('Y-m-d', time() - 24 * 3600) . ' 23:59:59';

    return $this->where('date_time >', $yesterday)
      ->findAll();
  }

  public function getLastSixMonths()
  {
    $sixMonthsAgo = date('Y-m-d', time() - 182 * 24 * 3600);
    // dd($sixMonthsAgo);
    return $this->where('date_time >', $sixMonthsAgo)
      ->orderBy('date_time', 'DESC')
      ->findAll();
  }

  public function getById($id)
  {
    return $this->where('id', $id)
      ->first();
  }

  public function getByCustomerId($customerId)
  {
    return $this->where('customer_id', $customerId)
      ->findAll();
  }
}
