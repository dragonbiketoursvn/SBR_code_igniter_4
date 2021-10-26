<?php

namespace App\Controllers;

class Test extends BaseController
{
	public function one()
	{
		return view('Test/one');
	}

	public function two()
	{
		return view('Test/two');
	}

	public function three()
	{
		return view('Test/three');
	}

	public function four()
	{
		return view('Test/four');
	}
}
