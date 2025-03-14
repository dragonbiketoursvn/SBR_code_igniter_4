<?php

namespace App\Controllers\Admin;

use App\Entities\Expense;

class Expenses extends \App\Controllers\BaseController
{
  private $model;
  private $bikesModel;
  private $categories;

  public function __construct()
  {
    $this->model = new \App\Models\ExpensesModel;
    $this->bikesModel = new \App\Models\BikesModel;
  }

  public function chooseDivision()
  {
    return view('Admin/Expenses/chooseDivision');
  }

  public function getInfo($division)
  {
    if ($division === 'SBR') {

      $expenseCategoriesModel = new \App\Models\SBRExpenseCategoriesModel;
      $expenseCategories = $expenseCategoriesModel->getCategories();
    } elseif ($division === 'Dragon') {

      $expenseCategoriesModel = new \App\Models\DragonBikesExpenseCategoriesModel;
      $expenseCategories = $expenseCategoriesModel->getCategories();
    } elseif ($division === 'Personal') {

      $expenseCategoriesModel = new \App\Models\DragonBikesExpenseCategoriesModel;
      $expenseCategories = $expenseCategoriesModel->getCategories();
    }

    $currentBikes = $this->bikesModel->getCurrentBikes();

    return view('Admin/Expenses/getInfo', [
      'division' => $division,
      'expenseCategories' => $expenseCategories,
      'currentBikes' => $currentBikes
    ]);
  }

  public function save()
  {
    $expense = new Expense;
    $expense->fill($this->request->getPost());
    $expense->user = session()->get('user_level');

    $result = $this->model->save($expense);
    if ($result === false) {

      return redirect()->back()
        ->with('errors', $this->model->errors())
        ->withInput();
    } else {

      return redirect()->to(site_url('Admin/Home/index'));
    }
  }

  public function viewAll()
  {
    $expenses = $this->model->getAll();
    return view('Admin/Expenses/viewAll', ['expenses' => $expenses]);
  }

  public function update($id)
  {
    $expense = $this->model->find($id);
    $currentBikes = $this->bikesModel->getCurrentBikes();

    return view('Admin/Expenses/update', ['expense' => $expense, 'currentBikes' => $currentBikes]);
  }

  public function saveUpdate()
  {
    $payment = $this->request->getPost();

    if ($this->model->save($payment)) {

      return redirect()->to(site_url('Admin/Expenses/viewAll'));
    } else {

      return redirect()->back()->with('errors', $this->model->errors());
    }
  }
}
