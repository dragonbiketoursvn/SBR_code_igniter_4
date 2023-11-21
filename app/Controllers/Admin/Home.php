<?php

namespace App\Controllers\Admin;

class Home extends \App\Controllers\BaseController
{
	public function index()
	{
		session()->remove('appointment');
		return view('Admin/Home/index');
	}
}
