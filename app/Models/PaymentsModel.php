<?php

namespace App\Models;

class PaymentsModel extends \CodeIgniter\Model
{
  protected $table = 'payments';

  protected $allowedFields = [
    'user', 'customer_id', 'customer_name', 'amount', 'amount_usd',
    'months_paid', 'payment_date', 'notes', 'payment_method'
  ];

  protected $returnType = 'App\Entities\Payment';

  protected $useTimestamps = false;

  protected $validationRules = [
    'amount' => 'required|numeric|greater_than[499]',
    'months_paid' => 'required|numeric|greater_than[-1]|less_than[10]',
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

  public function getByContractNumber($contractNumber)
  {
    return $this->where('customer_id', $contractNumber)
      ->orderBy('payment_date', 'DESC')
      ->findAll();
  }

  public function getTotalMonthsPaid($contractNumber)
  {

    return $this->where('customer_id', $contractNumber)
      ->selectSum('months_paid')
      ->get()
      ->getRow();
  }

  public function getTodaysRecords()
  {
    $yesterday = date('Y-m-d', time() - 24 * 3600) . ' 23:59:59';

    return $this->where('payment_date >', $yesterday)
      ->findAll();
  }
}
