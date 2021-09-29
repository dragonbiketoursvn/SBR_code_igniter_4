<?php

namespace App\Controllers;

use App\Models\BikesModel;
use App\Libraries\Token;

class Test extends BaseController
{

  public function testOne()
	{
<<<<<<< Updated upstream
    $model = new BikesModel;
    $currentBikes = $model->getCurrentBikes();
=======
    if ($this->request->getMethod() === 'get') {
      // If request type is 'get' then return view without passing in variables
      return view('Tests/test1get');
>>>>>>> Stashed changes

    } elseif ($this->request->getMethod() === 'post') {
      // Otherwise return view passing in value received via 'post'
      $test_value = $this->request->getPost('test_value');

      return view('Tests/test1get', ['test_value' => $test_value]);
    }
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
