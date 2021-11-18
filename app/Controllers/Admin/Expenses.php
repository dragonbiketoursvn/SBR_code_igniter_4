<?php

namespace App\Controllers\Admin;

use App\Entities\Expense;

class Expenses extends \App\Controllers\BaseController
{
    private $model;
    private $categories;

    public function __construct()
    {
        $this->model = new \App\Models\ExpensesModel;

    }

    public function chooseDivision()
    {
      return view('Admin/Expenses/chooseDivision');
    }

    public function getInfo($division)
    {
      if($division === 'SBR') {

        $expenseCategoriesModel = new \App\Models\SBRExpenseCategoriesModel;
        $expenseCategories = $expenseCategoriesModel->getCategories();

      } elseif($division === 'Dragon') {

        $expenseCategoriesModel = new \App\Models\DragonBikesExpenseCategoriesModel;
        $expenseCategories = $expenseCategoriesModel->getCategories();
      } elseif($division === 'Personal') {

        $expenseCategoriesModel = new \App\Models\DragonBikesExpenseCategoriesModel;
        $expenseCategories = $expenseCategoriesModel->getCategories();
      }


      return view('Admin/Expenses/getInfo', [
                                                     'division' => $division,
                                            'expenseCategories' => $expenseCategories
                                           ]);
    }

    public function save()
    {
      $expense = new Expense;
      $expense->fill($this->request->getPost());
      $expense->user = session()->get('user_level');

      $result = $this->model->save($expense);
      if($result === false) {

        return redirect()->back()
                         ->with('errors', $this->model->errors())
                         ->withInput();

      } else {

        return redirect()->to(site_url('Admin/Home/index'));

      }
    }

}