<?php

namespace App\Entities;

use App\Libraries\Token;

class Customer extends \CodeIgniter\Entity
{
      public function startActivation()
      {
          $token = new Token;

          $this->token = $token->getValue();

          $this->activation_hash = $token->getHash();

      }

      public function activate()
      {
          $this->currently_renting = 1;
          $this->activation_hash = 0;
      }
}
