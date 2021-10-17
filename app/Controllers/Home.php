<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$path = 'http://customartforyou.com/uploads/profile_images/1634112974_b57d5e090b33d40c0218.jpg';

		return view('Home/index', ['path' => $path]);
	}
}
