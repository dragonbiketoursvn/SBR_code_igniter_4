<?php

namespace App\Models;

class TestModel extends \CodeIgniter\Model
{
  protected $table = 'test';

  protected $allowedFields = ['text', 'moreText', 'passport', 'nextPhoto'];

  protected $returnType = 'App\Entities\Test';

  protected $useTimestamps = false;

  protected $validationRules = [];

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
}
