<?php

namespace App\Models;

use App\Libraries\Token;

class CaribeUsersModel extends \CodeIgniter\Model
{
  protected $table = 'caribe_users';

  protected $allowedFields = ['name', 'email', 'password_hash', 'level'];

  protected $returnType = 'App\Entities\CaribeUser';

  protected $useTimestamps = true;

  protected $validationRules = [];

  protected $validationMessages = [];

  protected function hashPassword(array $data)
  {
    if (isset($data['data']['password'])) {

      $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

      unset($data['data']['password']);
      unset($data['data']['password_confirmation']);
    }

    return $data;
  }

  public function findByEmail($email)
  {
    return $this->where('email', $email)
      ->first();
  }
}
