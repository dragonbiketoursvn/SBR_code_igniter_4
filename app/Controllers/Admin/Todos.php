<?php

namespace App\Controllers\Admin;

use App\Entities\Todo;

class Todos extends \App\Controllers\BaseController
{
  private $model;

  public function __construct()
  {
    $this->model = new \App\Models\TodosModel;
  }

  public function getIncomplete()
  {
    $result = $this->model->getIncomplete();
    return $this->response->setJSON($result);
  }

  public function addTask()
  {
    $failureMessage = ['message' => 'fail'];
    $successMessage = ['message' => 'success'];
    $post = $this->request->getPost();
    $todo = new Todo($post);
    // test
    if (!$this->model->save($todo)) {
      return $this->response->setJSON($failureMessage);
    } else {
      $recordID = $this->model->getNewest();
      $insertedRecord = $this->model->getByID($recordID->id);
      return $this->response->setJSON($insertedRecord);      
    }
  }

  public function markDone()
  {
    $failureMessage = ['message' => 'fail'];
    $successMessage = ['message' => 'success'];
    $id = $this->request->getPost('id');
    $todo = $this->model->getByID($id);
    $todo->complete = 1;
    $current_time = time();
    $todo->time_completed = date("Y-m-d H:i:s", $current_time); 

    if (!$this->model->save($todo)) {
      return $this->response->setJSON($failureMessage);
    } else {
      return $this->response->setJSON($successMessage);      
    }
  }

  public function updateTask()
  {
    $post = $this->request->getPost();
    $task = new Todo($post);
    $failureMessage = ['message' => 'fail'];
    $successMessage = ['message' => 'success'];

    if ($this->model->save($task)) {
      return $this->response->setJSON($successMessage);
    } else {
      return $this->response->setJSON($failureMessage);
    }
  }

  public function viewList()
  {
    return view('Admin/Todos/viewList');
  }

}
