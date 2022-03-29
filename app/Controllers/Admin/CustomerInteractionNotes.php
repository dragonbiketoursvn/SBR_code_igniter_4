<?php

namespace App\Controllers\Admin;

use App\Entities\CustomerInteractionNote;


class CustomerInteractionNotes extends \App\Controllers\BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\CustomerInteractionNotesModel;
    }

    public function create()
    {
        $post = $this->request->getPost();
        $note = new CustomerInteractionNote($post);
        $responseContent = null;

        if ($this->model->save($note)) {

            $responseContent = ['success' => 'note added'];
        } else {

            $responseContent = ['error' => 'note not added'];
        }

        return $this->response->setJSON($responseContent);
    }

    public function getAll()
    {
        $tickets = $this->model->getAll();

        return $this->response->setJSON($tickets);
    }
}
