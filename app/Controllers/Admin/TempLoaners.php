<?php

namespace App\Controllers\Admin;

use App\Entities\TempLoaner;

class TempLoaners extends \App\Controllers\BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\TempLoanersModel;
    }

    // creates a new ticket when a bike is collected from renter
    public function create()
    {
        $post = $this->request->getPost();
        $ticket = new TempLoaner($post);

        // make sure that plate_number is a valid value by checking against current bikes
        $model = new \App\Models\BikesModel;
        $bikes = $model->getCurrentBikes();
        $plateNumbers = [];

        foreach ($bikes as $bike) {
            $plateNumbers[] = $bike->plate_number;
        }

        if (!in_array($ticket->plate_number, $plateNumbers)) {
            return $this->response->setJSON(['message' => 'please check the plate numbers']);
        }

        if ($this->model->save($ticket)) {
            return $this->response->setJSON(['message' => 'success']);
        } else {
            return $this->response->setJSON(['message' => 'failed to create record']);
        }
    }

    // updates the ticket to show that the repairs have been completed
    public function closeTicket()
    {
        $plateNumber = $this->request->getPost('plate_number');
        $openTickets = $this->model->getAll();
        $plateNumbers = [];

        foreach ($openTickets as $openTicket) {
            $plateNumbers[] = $openTicket->plate_number;
        }

        if (!in_array($plateNumber, $plateNumbers)) {
            return $this->response->setJSON(['message' => 'please check the plate numbers']);
        }

        $ticket = $this->model->getOpenTicket($plateNumber);
        $ticket->status = 'returned';

        if ($this->model->save($ticket)) {
            return $this->response->setJSON(['message' => 'success']);
        } else {
            return $this->response->setJSON(['message' => 'failed to update record']);
        }
    }

    // creates a new ticket when a bike is collected from renter
    public function saveAsync()
    {
        $post = $this->request->getPost();
        $ticket = new TempLoaner($post);

        // make sure that plate_number is a valid value by checking against current bikes
        $model = new \App\Models\BikesModel;
        $bikes = $model->getCurrentBikes();
        $plateNumbers = [];
        $responseContent = null;

        foreach ($bikes as $bike) {
            $plateNumbers[] = $bike->plate_number;
        }

        if (!in_array($ticket->plate_number, $plateNumbers)) {
            $responseContent = ['message' => 'please check the plate numbers'];
        } else if ($this->model->save($ticket)) {

            $responseContent = ['success' => 'new temp loaner ticket created'];
        } else {

            $responseContent = ['error' => 'temp loaner ticket not created'];
        }

        return $this->response->setJSON($responseContent);
    }

    // updates the ticket to show that the repairs have been completed
    public function closeTicketAsync()
    {
        // get currently open ticket with matching plate number
        $plateNumber = $this->request->getPost('plate_number');
        $ticket = $this->model->getOpenTicket($plateNumber);
        $responseContent = null;

        $ticket->status = 'returned';

        if ($this->model->save($ticket)) {

            $responseContent = ['success' => 'temp loaner ticket closed'];
        } else {

            $responseContent = ['error' => 'temp loaner ticket  not closed'];
        }

        return $this->response->setJSON($responseContent);
    }
}
