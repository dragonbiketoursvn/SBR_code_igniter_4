<?php

namespace App\Controllers\Admin;

class PayPal extends \App\Controllers\BaseController
{
  public function payment()
  {
    return view('Admin/PayPal/payment');
  }
}
