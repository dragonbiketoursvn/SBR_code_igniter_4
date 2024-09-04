<?php

namespace App\Controllers\Admin;

use App\Entities\ParkingRecord;
use App\Models\ParkedInGarageModel;
use App\Models\BikesModel;

class ParkedInGarage extends \App\Controllers\BaseController
{
  private $model;
  private $bikesModel;
  private $db;

  public function __construct()
  {
    $this->model = new \App\Models\ParkedInGarageModel;
    $this->bikesModel = new \App\Models\BikesModel;
    $this->db = \Config\Database::connect();
  }

  public function addRecords()
  {
    $currentBikes = $this->bikesModel->getCurrentBikes();
    return view('Admin/ParkedInGarage/inputRecords', ['currentBikes' => $currentBikes,]);
  }

  public function saveRecords()
  {
    $todaysRecords = $this->request->getPost();
    $plateNumbers = [];

    foreach ($todaysRecords as $plateNumber) {
      if ($plateNumber !== "") {
        $plateNumbers[] = $plateNumber;
      }
    }

    foreach ($plateNumbers as $plateNumber) {
      $record = new ParkingRecord();
      $record->plate_number = $plateNumber;
      $record->date = date('Y-m-d H:i:s');
      $this->model->insert($record);
    }

    $this->response->setHeader('Access-Control-Allow-Origin', 'https://hagiangadventures.com');
    return $this->response->setJSON(['message' => 'THÀNH CÔNG!!!']);
  }


  public function viewAll()
  {
    $sql = "SELECT pig.plate_number, b.model, b.year, pig.date
            FROM parked_in_garage pig
            JOIN bikes b 
            ON pig.plate_number = b.plate_number
            WHERE pig.date = (
              SELECT MAX(date)
              FROM parked_in_garage
            )
            ORDER BY model, year";
    $bikesInGarage = $this->db->query($sql)->getResult();
    return view('Admin/ParkedInGarage/viewAll', ['bikesInGarage' => $bikesInGarage,]);
  }
}
