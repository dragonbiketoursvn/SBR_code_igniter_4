<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$model = new \App\Models\PaymentsModel;
		$result = $model->select('customer_name')->selectSum('months_paid')->where('contract_number', 3580)->get()->getRow();
		dd($result->months_paid);

		//->getResultArray()

		return view('Home/index');
	}
}
