<?php

namespace App\Libraries;

use App\Libraries\Token;
//use App\Models\AppointmentsModel;

class Authentication
{
  public function validateToken($token)
  {

    $newToken = new Token($token);
    $hash = $newToken->getHash();

    $model = new \App\Models\AppointmentsModel;

    $appointment = $model->where('activation_hash', $hash)->first();

    if($appointment === null) {

      $response = service('response');
      $response->setStatusCode(403);
      $response->setBody('You do not have permission to access that resource');

      return $response;
    }

    return $appointment;
  }
}
