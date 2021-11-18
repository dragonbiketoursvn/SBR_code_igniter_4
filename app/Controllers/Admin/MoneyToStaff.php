<?php

namespace App\Controllers\Admin;

use App\Entities\MoneyToStaff as EntitiesMoneyToStaff;
use App\Entities\MoneyToStaffRecord;

class MoneyToStaff extends \App\Controllers\BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\MoneyToStaffModel;

    }

    public function getInfo()
    {
        return view('Admin/MoneyToStaff/getInfo');
    }

    public function save()
    {
        $money = new MoneyToStaffRecord($this->request->getPost());
        $this->model->save($money);

        return redirect()->to(site_url('Admin/Home'));
    }

}