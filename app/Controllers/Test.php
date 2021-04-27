<?php

namespace App\Controllers;

use App\Models\AppointmentsModel;
use App\Libraries\Token;

class Test extends BaseController
{

  public function testOne()
	{
    return view('Tests/test1');
  }

  public function testTwo()
	{
    $post = $this->request->getPost('value_one');
    //dd($post);
    //return view('Tests/test2', [ 'thomas' => $post]);
    return view('Tests/test2', [ 'thomas' => $post]);
  }

  public function testThree()
	{
    $post = $this->request->getPost('value_two');
    //dd($post);
    return view('Tests/test3', [ 'henrietta' => $post]);
  }

  public function testFour()
  {
    $post = $this->request->getPost('value_three');
    //dd($post);
    return view('Tests/test4', [ 'dildo' => $post]);
  }

}
