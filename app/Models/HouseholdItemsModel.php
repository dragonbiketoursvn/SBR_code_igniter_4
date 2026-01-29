<?php

namespace App\Models;

class HouseholdItemsModel extends \CodeIgniter\Model
{
  protected $table = 'household_items';

  protected $allowedFields = [
    'box',
    'category_english',
    'category_vietnamese',
    'description_english',
    'description_vietnamese',
    'photo'
  ];

  protected $useTimestamps = false;

  protected $returnType = 'App\Entities\HouseholdItem';


  protected $validationRules = [
    'box' => 'required',
    'photo' => 'required'
  ];


  protected $validationMessages = [
    'box' => 'Specify box',
    'photo' => 'Add a photo'
  ];

  public function getAll()
  {
    return $this->orderBy('box')->findAll();
  }
}
