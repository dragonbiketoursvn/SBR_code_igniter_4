<?php

namespace App\Models;

class DragonBikesExpenseCategoriesModel extends \CodeIgniter\Model
{
  protected $table = 'dragonbikes_expense_categories';

  protected $allowedFields = [];

  protected $useTimestamps = false;

  protected $validationRules = [];

  protected $validationMessages = [];

  public function getCategories() {
    return $this->findAll();
  }

}