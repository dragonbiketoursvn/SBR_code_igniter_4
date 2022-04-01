<?php

namespace App\Controllers\Caribe;

class Home extends \App\Controllers\BaseController
{
  public function index()
  {
    return view('Caribe/index');
  }
}
