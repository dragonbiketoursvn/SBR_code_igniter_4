<?php

namespace App\Controllers\Admin;

class PayPal extends \App\Controllers\BaseController
{
  public function payment()
  {
    dd('blah');
    return view('Admin/PayPal/payment');
  }
}
