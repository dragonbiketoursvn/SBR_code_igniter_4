<?php

namespace App\Models;

class PaymentsModel extends \CodeIgniter\Model
{
    protected $table = 'payments';

    protected $allowedFields = ['user', 'contract_number', 'customer_name', 'amount', 'months_paid', 'payment_date', 'notes', 'payment_method'];

    protected $returnType = 'App\Entities\Payment';

    protected $useTimestamps = false;

    protected $validationRules = [
                                  'amount' => 'required|numeric|greater_than[499]|less_than[10000]',
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

}
