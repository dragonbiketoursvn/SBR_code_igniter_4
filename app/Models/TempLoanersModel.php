<?php

namespace App\Models;

class TempLoanersModel extends \CodeIgniter\Model
{
    protected $table = 'temp_loaners';
    protected $primaryKey = 'id';

    protected $allowedFields = ['plate_number', 'status', 'customer_name', 'customer_id'];

    protected $returnType = 'App\Entities\TempLoaner';

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

    // gets all bikes that are currently loaned out as temp bikes
    public function getAll()
    {
        return $this->where('status', 'loaned')
            ->findAll();
    }

    // gets ticket for one currently loaned out bike
    public function getOpenTicket($plateNumber)
    {
        return $this->where('plate_number', $plateNumber)
            ->where('status', 'loaned')
            ->orderBy('date_created', 'DESC')
            ->first();
    }
}
