<?php

namespace App\Controllers\Admin;

class Home extends \App\Controllers\BaseController
{
	public function index()
	{
		session()->remove('appointment');
		session()->set('test', 'session test');
		dd(session()->get());
		return view('Admin/Home/index');
	}
}
