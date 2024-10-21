<?php

namespace App\Controllers\Admin;

use App\Entities\ParkingRecord;
use App\Models\ParkedInGarageModel;
use App\Models\BikesModel;

class ParkedInGarage extends \App\Controllers\BaseController
{
  private $model;
  private $bikesModel;
  private $bikeStatusChangeModel;
  private $db;

  public function __construct()
  {
    $this->model = new \App\Models\ParkedInGarageModel;
    $this->bikesModel = new \App\Models\BikesModel;
    $this->bikeStatusChangeModel = new \App\Models\BikeStatusChangeModel;
    $this->db = \Config\Database::connect();
  }

  public function addRecords()
  {
    $currentBikes = $this->bikesModel->getCurrentBikes();
    return view('Admin/ParkedInGarage/inputRecords', ['currentBikes' => $currentBikes,]);
  }

  public function saveRecords()
  {
    $post = $this->request->getPost();
    $location = array_shift($post);
    $plateNumbers = $post;

    // foreach ($plateNumbers as $plateNumber) {
    //   if ($plateNumber !== "") {
    //     $plateNumbers[] = $plateNumber;
    //   }
    // }

    foreach ($plateNumbers as $plateNumber) {
      if ($plateNumber !== "") {
        $record = new ParkingRecord();
        $record->plate_number = $plateNumber;
        $record->date = date('Y-m-d H:i:s');
        $record->location = $location;
        $this->model->insert($record);
      }
    }

    $this->response->setHeader('Access-Control-Allow-Origin', 'https://hagiangadventures.com');
    return $this->response->setJSON(['message' => 'THÀNH CÔNG!!!']);
    // return $this->response->setJSON(['message' => $plateNumbers]);
  }


  public function viewAll()
  {
    $sql = "SELECT t2.plate_number, b.model, b.year, t2.date, t2.location
            FROM bikes b
            JOIN (
            SELECT plate_number, date, location
            FROM parked_in_garage
            WHERE (plate_number, date)
            IN (
            SELECT plate_number, MAX(date) AS date
            FROM (
            SELECT *
            FROM parked_in_garage 
            WHERE date IN (
              SELECT MAX(date)
                FROM parked_in_garage
                WHERE location = 'garage'
            ) OR date IN (
              SELECT MAX(date)
                FROM parked_in_garage
                WHERE location = 'home'
            ) OR date IN (
              SELECT MAX(date)
                FROM parked_in_garage
                WHERE location = 'sym'
            ) OR date IN (
              SELECT MAX(date)
                FROM parked_in_garage
                WHERE location = 'tay'
            )
            )t1
                
            GROUP BY plate_number
            )  
            ORDER BY `parked_in_garage`.`date` DESC
            )t2
            ON b.plate_number = t2.plate_number
             ORDER BY model, year, plate_number";
    // $sql = "SELECT pig.plate_number, b.model, b.year, pig.date
    //         FROM parked_in_garage pig
    //         JOIN bikes b 
    //         ON pig.plate_number = b.plate_number
    //         WHERE pig.date = (
    //           SELECT MAX(date)
    //           FROM parked_in_garage
    //         )
    //         ORDER BY model, year, plate_number";
    $bikesInGarage = $this->db->query($sql)->getResult();

    // get most recent bsc record for each bike, check whether ->temporary === '1'
    // and if so, add ->temporary = 1 to object (otherwise = 0)

    $bikesWithTempStatus = [];

    foreach ($bikesInGarage as $bikeInGarage) {
      $temporary = 0;
      $currentStatusChange = $this->bikeStatusChangeModel->getCurrentStatusByPlateNumber($bikeInGarage->plate_number);

      if (is_object($currentStatusChange) && $currentStatusChange->temporary === '1') {
        $temporary = 1;
      }
      $bikeInGarage->temporary = $temporary;
      $bikesWithTempStatus[] = $bikeInGarage;
    }
    $bikeInGarage = $bikesWithTempStatus;

    return view('Admin/ParkedInGarage/viewAll', ['bikesInGarage' => $bikesInGarage,]);
    // return view('Admin/ParkedInGarage/viewAll', ['bikesWithTempStatus' => $bikesWithTempStatus,]);
  }
}
