<?php

namespace App\Models;

class RenterIncidentModel extends \CodeIgniter\Model
{
    protected $table = 'renter_incidents';

    protected $allowedFields = ['contract_number', 'date', 'customer_name', 'type', 'cost_incurred', 'resolution'];

    protected $returnType = 'App\Entities\RenterIncident';

    protected $useTimestamps = false;

    protected $validationRules = [
                                  'customer_name' => 'required',
                                  'type' => 'required',
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

    public function getAll()
    {
      return $this->findAll();
    }

    public function getByName($name)
    {
      return $this->where('customer_name', $name)
                  ->findAll();
    }

    public function getById($id)
    {
      return $this->find($id);
    }

    public function getUnresolved()
    {
      return $this->where('resolution', null)
                  ->orWhere('resolution', '')
                  ->findAll();
    }

}