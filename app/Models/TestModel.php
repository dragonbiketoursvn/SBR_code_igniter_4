<?php

namespace App\Models;

use CodeIgniter\Model;

class TestModel extends Model
{
  protected $table = 'test';

  protected $allowedFields = ['text', 'moreText', 'passport', 'nextPhoto'];
  protected $returnType = 'App\Entities\Test';
  protected $validationRules = [
    'text' => 'required',
    'moreText' => 'required',
  ];
  protected $validationMessages = [
    'text' => ['required' => 'The text field cannot be empty'],
    'moreText' => ['required' => 'The moreText field cannot be empty'],
  ];

  public function getAll()
  {
    return $this->findAll();
  }

  public function getById($id)
  {
    return $this->find($id);
  }
}
