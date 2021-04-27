<?php

namespace App\Libraries;

use App\Libraries\Token;
use App\Models\AppointmentsModel;

class Authentication
{
  protected $model;

  public function __construct()
  {
      $this->model = new AppointmentsModel;
  }

  public function validateToken($token)
  {
    $newToken = new Token($token);
    $hash = $newToken->getHash();
    $appointment = $this->model->where('activation_hash', $hash)->first();

    if($appointment === null) {
      
      $response = service('response');
      $response->setStatusCode(403);
      $response->setBody('You do not have permission to access that resource');

      return $response;
    };

  }
}
