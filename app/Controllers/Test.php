<?php

namespace App\Controllers;

use App\Models\BikesModel;
use App\Libraries\Token;

class Test extends BaseController
{

  public function testOne()
	{
    $model = new BikesModel;
    $currentBikes = $model->getCurrentBikes();

    return view('Tests/test1', ['currentBikes', $currentBikes]);
  }

  public function intermediateOne() {

      $post = $this->request->getPost('value_one');

      return redirect()->to("intermediateTwo/{$post}");
  }

  public function intermediateTwo($post) {

      //dd(site_url("testTwo/{$post}"));
      return redirect()->to(site_url("Test/testTwo/{$post}"));
  }

  public function testTwo($post)
	{
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
