<?php

namespace App\Models;

class CompensationTicketsModel extends \CodeIgniter\Model
{
  protected $table = 'compensation_tickets';
  protected $primaryKey = 'id';

  protected $allowedFields = [
    'date',
    'plate_number',
    'customer_id',
    'cost_incurred',
    'total_paid',
    'still_outstanding',
    'stolen_destroyed_damaged',
    'active'
  ];

  protected $returnType = 'App\Entities\CompensationTicket';

  protected $useTimestamps = false;

  protected $beforeUpdate = ['trimWhiteSpace'];
  protected $beforeInsert = ['trimWhiteSpace'];

  protected function trimWhiteSpace($data)
  {
    array_walk($data['data'], function (&$item) {

      $item = trim($item);
    });

    return $data;
  }

  public function getActiveTicketsByPlateNumber($plateNumber)
  {
    return $this->where('plate_number', $plateNumber)
      ->where('active', 1)
      ->first();
  }

  public function getActiveTicketsByCustomerId($customerId)
  {
    return $this->where('customer_id', $customerId)
      ->where('active', 1)
      ->first();
  }

  public function getActiveTickets()
  {
    return $this->where('active', 1)->findAll();
  }

  public function getCustomerIdsWithActiveTickets()
  {
    return $this->where('active', 1)
      ->select('customer_id')
      ->findAll();
  }

  public function getTicketById($id)
  {
    return $this->where('id', $id)->first();
  }
}
