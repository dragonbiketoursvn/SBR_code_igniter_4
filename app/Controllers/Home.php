<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		return view('Home/index');
	}

	public function test1()
	{
		dd('test1');
	}

	public function test2()
	{
		dd('test2');
	}
}
