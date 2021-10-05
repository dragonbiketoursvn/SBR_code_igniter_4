<?php

namespace App\Models;

use App\Libraries\Token;

class RepairsModel extends \CodeIgniter\Model
{
    protected $table = 'repairs';

    protected $allowedFields = ['plate_number', 'repair_date', 'odometer', 'total_cost', 'labor_cost', 'nhot', 'item_1', 'item_2', 'item_3',
                                'item_4','item_5', 'item_6', 'item_7', 'item_8', 'item_9', 'item_10', 'item_11', 'item_12', 'item_13',
                                'item_14', 'item_15', 'item_16', 'item_17', 'item_18', 'item_19', 'item_20',];

    protected $returnType = 'App\Entities\Repair';

    protected $useTimestamps = false;

    protected $validationRules = [
                                    'repair_date' => 'required|valid_date[Y-m-d]',
                                    'total_cost' => 'required|numeric|less_than[10000]',
                                  ];

    protected $validationMessages = [
                                      'repair_date' => 'Ghi lại ngày sửa',
                                      'total_cost' => 'Ghi lại giá tổng cộng',
                                    ];

    public function findByPlateNumber($plateNumber)
    {
        return $this->where('plate_number', $plateNumber)
                    ->orderBy('repair_date', 'DESC')
                    ->findAll();
    }
    
}