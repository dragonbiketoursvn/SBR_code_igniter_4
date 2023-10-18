<?php

namespace App\Controllers;

class Home extends BaseController
{
	// this comment is for testing purposes
	public function index()
	{
		return view('Home/index');
	}
}
