<?php

namespace App\Models;

class TodosModel extends \CodeIgniter\Model
{
  protected $table = 'todos';

  protected $allowedFields = [
    'description', 'subtask', 'time_completed', 'due_date', 'plate_number', 'complete',
    'parent_id', 'priority'
  ];

  protected $returnType = 'App\Entities\Todo';

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

  public function getIncomplete()
  {
    return $this->where('complete', 0)
                ->findAll();
  }

  public function getComplete()
  {
    return $this->where('complete', 1)
                ->findAll();
  }

  public function getByID($id)
  {
    return $this->where('id', $id)
                ->first();
  }

  public function getNewest()
  {
    return $this->selectMax('id')
                ->first();
  }
}
