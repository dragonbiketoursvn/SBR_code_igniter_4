<?php

namespace App\Models;

class PaymentsModel extends \CodeIgniter\Model
{
    protected $table = 'payments';

    protected $allowedFields = ['user', 'contract_number', 'customer_name', 'amount', 'months_paid', 'payment_date', 'notes', 'payment_method'];

    protected $returnType = 'App\Entities\Payment';

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

}
