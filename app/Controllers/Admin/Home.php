<?php

namespace App\Controllers\Admin;

class Home extends \App\Controllers\BaseController
{
	public function index()
	{
		return view('Admin/Home/index');
	}
}
