<?php

namespace App\Models;

class SBRExpenseCategoriesModel extends \CodeIgniter\Model
{
  protected $table = 'sbr_expense_categories';

  protected $allowedFields = [];

  protected $useTimestamps = false;

  protected $validationRules = [];

  protected $validationMessages = [];

  public function getCategories() {
    return $this->findAll();
  }

}