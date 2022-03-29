<?php

namespace App\Controllers\Admin;

use App\Entities\Test;

class Tests extends \App\Controllers\BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\TestModel;
    }

    public function photoBoxTest()
    {
        $model = new \App\Models\CustomersModel;
        $customers = $model->getCurrentCustomers();

        return view('Admin/Tests/photoBoxTest', ['customers' => $customers]);
    }

    public function viewAll()
    {
        $customerModel = new \App\Models\CustomersModel;
        $customers = $customerModel->getCurrentCustomers();

        return view('Admin/Tests/viewAll', ['customers' => $customers]);
    }

    public function getRecords()
    {
        $records = $this->model->getAll();

        return $this->response->setJSON($records);
    }

    public function asyncSubmit()
    {
        $test = new Test;
        $test->fill($this->request->getPost());
        $files = $this->request->getFiles();

        $test = service('photos')->savePhoto($test, $files);

        if ($this->model->save($test)) {
            return $this->response->setJson(['message' => 'Success!']);
        } else {
            return $this->response->setJson($this->model->errors());
        }
    }

    public function updateRecord()
    {
        $test = new Test;
        $test->fill($this->request->getPost());
        $files = $this->request->getFiles();

        $test = service('photos')->savePhoto($test, $files);

        if ($this->model->save($test)) {
            return $this->response->setJson('Success!');
        }
    }

    public function repairAndReturnTickets()
    {
        return view('Tests/repairAndReturnTickets');
    }
}
