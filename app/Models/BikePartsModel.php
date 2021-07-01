<?php

namespace App\Models;


class BikePartsModel extends \CodeIgniter\Model
{
    protected $table = 'bike_parts';

    protected $allowedFields = ['part_name'];

    protected $returnType = 'App\Entities\BikePart';

    protected $useTimestamps = false;

    protected $validationRules = [];

    protected $validationMessages = [];

    public function findDistinct()
    {
        return $this->select('part_name')
                    ->distinct()
                    ->findAll();
    }

}
