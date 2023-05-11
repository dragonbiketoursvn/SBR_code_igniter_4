<?php

namespace App\Models;

class AppointmentsModel extends \CodeIgniter\Model
{
  protected $table = 'appointments';

  protected $allowedFields = [
    'contract_number', 'customer_name', 'customer_id', 'current_bike', 'pay_rent', 'full_service', 'small_service', 'appointment_time',
    'building_name', 'number', 'street_name', 'ward', 'district', 'appointment_completed', 'activation_hash',
    'paid_rent', 'received_bike', 'returned_bike', 'notes'
  ];

  protected $returnType = 'App\Entities\Appointment';

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

  public function getScheduledAppointments()
  {
    $date = strtotime("yesterday"); // otherwise today's appointments won't be visible after their time passes
    return $this->where('appointment_time >', date('Y-m-d H:i:s', $date))->findAll();
  }

  public function getCompletedAppointments()
  {

    return $this->where('appointment_time >', date('Y-m-d H:i:s', time() - 1 * 24 * 3600))
      ->where('appointment_completed', 1)
      ->findAll();
  }

  public function getNewestRecord()
  {
    return $this->orderBy('id', 'DESC')->first();
  }
}
