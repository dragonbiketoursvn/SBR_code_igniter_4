<?php

namespace App\Controllers\Admin;

class Home extends \App\Controllers\BaseController
{
	public function index()
	{
		session()->remove('appointment'); // clear appointment session variable if it's there
		return view('Admin/Home/index');
	}
}
