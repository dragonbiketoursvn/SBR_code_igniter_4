<?php

namespace App\Models;

class BikeValuationsModel extends \CodeIgniter\Model
{
  protected $table = 'bike_valuations';

  protected $allowedFields = ['brand', 'model', 'year', 'value'];

  protected $returnType = 'App\Entities\BikeValuation';

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

  public function getValueByModelAndYear($model, $year)
  {
    return $this->select('value')
                ->where('model', $model)
                ->where('year', $year)
                ->first();
  }

}
