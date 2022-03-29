<?php

namespace App\Models;

class CustomerInteractionNotesModel extends \CodeIgniter\Model
{
    protected $table = 'customer_interaction_notes';

    protected $allowedFields = [
        'customer_name', 'customer_id', 'notes',
    ];

    protected $returnType = 'App\Entities\CustomerInteractionNote';

    protected $useTimestamps = false;

    protected $validationRules = [
        'customer_id' => 'required',
        'customer_name' => 'required',
    ];

    protected $validationMessages = [
        'customer_id' => 'no customer id entered',
        'customer_name' => 'no customer name entered',
    ];

    protected $beforeUpdate = ['trimWhiteSpace'];
    protected $beforeInsert = ['trimWhiteSpace'];

    protected function trimWhiteSpace($data)
    {
        array_walk($data['data'], function (&$item) {

            $item = trim($item);
        });

        return $data;
    }

    protected function getAll()
    {
        return $this->findAll();
    }
}
