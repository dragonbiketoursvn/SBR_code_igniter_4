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
}
