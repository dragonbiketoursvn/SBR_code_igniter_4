<?php

namespace App\Models;

class CompensationPaymentsModel extends \CodeIgniter\Model
{
  protected $table = 'compensation_payments';
  protected $primaryKey = 'id';

  protected $allowedFields = [
    'date',
    'amount',
    'compensation_ticket_id',
    'payment_method'
  ];

  protected $returnType = 'App\Entities\CompensationPayment';

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

  public function getTotalPaidOnTicket($ticketId)
  {
    return $this->selectSum('amount')
      ->where('compensation_ticket_id', $ticketId)
      ->get()
      ->getResult();
  }
}
