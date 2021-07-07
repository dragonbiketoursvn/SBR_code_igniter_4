<?php

namespace App\Models;

class ExpensesModel extends \CodeIgniter\Model
{
    protected $table = 'expenses';

    protected $allowedFields = ['category', 'amount', 'date', 'quantity', 'notes', 'dragon_bikes'];

    protected $useTimestamps = false;

    protected $validationRules = [
                                   'category' => 'required',
                                     'amount' => 'required|numeric',
                                       'date' => 'required|valid_date[Y-m-d]',
                                 ];


    protected $validationMessages = [
                                      'category' => 'Chọn một danh mục',
                                        'amount' => 'Ghi lại khoản tiền',
                                          'date' => 'Ghi lại ngày',
                                    ];

}
