<?php

namespace App\Controllers;

class Home extends BaseController
{
	// this is a new comment for testing purposes
	public function index()
	{
		return view('Home/index');
	}
}
