<?php

namespace App\Controllers\Admin;

use App\Entities\RepairAndReturnTicket;

class RepairAndReturnTickets extends \App\Controllers\BaseController
{
    private $model;

    public function __construct()
    {
        $this->model = new \App\Models\RepairAndReturnTicketsModel;
    }

    // creates a new ticket when a bike is collected from renter
    public function create()
    {
        $post = $this->request->getPost();
        $ticket = new RepairAndReturnTicket($post);

        // make sure that plate_number is a valid value by checking against current bikes
        $model = new \App\Models\BikesModel;
        $bikes = $model->getCurrentBikes();
        $plateNumbers = [];

        foreach ($bikes as $bike) {
            $plateNumbers[] = $bike->plate_number;
        }

        if (!in_array($ticket->plate_number, $plateNumbers)) {
            return $this->response->setJSON(['message' => 'please enter a valid plate number']);
        }

        if ($this->model->save($ticket)) {
            return $this->response->setJSON(['message' => 'success']);
        } else {
            return $this->response->setJSON(['message' => 'failed to create record']);
        }
    }

    // updates the ticket to show that the repairs have been completed
    public function closeRepairTicket()
    {
        $plateNumber = $this->request->getPost('plate_number');
        $ticket = $this->model->getOpenTicket($plateNumber);
        $ticket->repair_status = 'closed';

        if ($this->model->save($ticket)) {
            return $this->response->setJSON(['message' => 'success']);
        } else {
            return $this->response->setJSON(['message' => 'failed to update record']);
        }
    }

    // updates the ticket to show that the bike has been returned
    public function closeReturnTicket()
    {
        $plateNumber = $this->request->getPost('plate_number');
        $ticket = $this->model->getOpenTicket($plateNumber);
        $ticket->return_status = 'closed';

        if ($this->model->save($ticket)) {
            return $this->response->setJSON(['message' => 'success']);
        } else {
            return $this->response->setJSON(['message' => 'failed to update record']);
        }
    }

    public function getDueForRepair()
    {
        $dueForRepairList = $this->model->getDueForRepair();

        return $this->response->setJSON($dueForRepairList);
    }

    public function getDueForReturn()
    {
        $dueForReturnList = $this->model->getDueForReturn();

        return $this->response->setJSON($dueForReturnList);
    }

    // creates a new ticket when a bike is collected from renter
    public function saveAsync()
    {
        $post = $this->request->getPost();
        $ticket = new RepairAndReturnTicket($post);

        // make sure that plate_number is a valid value by checking against current bikes
        $model = new \App\Models\BikesModel;
        $bikes = $model->getCurrentBikes();
        $plateNumbers = [];
        $responseContent = null;

        foreach ($bikes as $bike) {
            $plateNumbers[] = $bike->plate_number;
        }

        if (!in_array($ticket->plate_number, $plateNumbers)) {

            $responseContent = ['error' => 'please enter a valid plate number'];
        }

        if ($this->model->save($ticket)) {

            $responseContent = ['success' => 'new ticket created'];
        } else {

            $responseContent = ['error' => 'ticket not created'];
        }

        return $this->response->setJSON($responseContent);
    }

    // updates the ticket to show that the repairs have been completed
    public function closeRepairTicketAsync()
    {
        $plateNumber = $this->request->getPost('plate_number');
        $ticket = $this->model->getOpenTicket($plateNumber);

        if (empty($ticket)) {
            return $this->response->setJSON(['error' => 'no open repair and return ticket found']);
        }

        $ticket->repair_status = 'closed';
        $responseContent = null;

        if ($this->model->save($ticket)) {

            $responseContent = ['success' => 'repair and return ticket closed'];
        } else {

            $responseContent = ['failure' => 'repair and return ticket not closed!'];
        }

        return $this->response->setJSON($responseContent);
    }
}
