<?php

namespace App\Models;

class RepairAndReturnTicketsModel extends \CodeIgniter\Model
{
    protected $table = 'repair_and_return_tickets';
    protected $primaryKey = 'id';

    protected $allowedFields = ['plate_number', 'repair_status', 'return_status', 'return_to', 'customer_id'];

    protected $returnType = 'App\Entities\RepairAndReturnTicket';

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

    // gets all bikes that have been collected for repair and are still due
    public function getAllDueForRepair()
    {
        return $this->where('repair_status', 'open')
            ->findAll();
    }

    // gets all bikes that have been collected for repair and have been repaired but not yet returned
    public function getAllDueForReturn()
    {
        return $this->where('repair_status', 'closed')
            ->where('return_status', 'open')
            ->findAll();
    }

    // gets current open ticket for bike with given plate number
    public function getOpenTicket($plateNumber)
    {
        return $this->where('plate_number', $plateNumber)
            ->where('return_status', 'open')
            ->orderBy('date_created', 'DESC')
            ->first();
    }
}
