<?php

namespace App\Controllers\Admin;

use App\Models\BikeStatusChangeModel;


class BikeStatusChanges extends \App\Controllers\BaseController
{
  private $model;
  private $db;

  public function __construct()
  {
    $this->model = new BikeStatusChangeModel();
    $this->db = \Config\Database::connect();
  }

  public function fetchAll()
  {
    $records = $this->model->orderBy('date_time', 'DESC')->findAll();
    return $this->response->setJSON($records);
  }

  public function viewLastSixMonths()
  {
    $records = $this->model->getLastSixMonths();
    return view('Admin/BikeStatusChanges/viewLastSixMonths', ['records' => $records]);
  }


  public function viewInfo()
  {
    $id = $this->request->getPost('id');

    if (!$id) {
      return redirect()->back();
    }

    $bikeStatusChange = $this->model->getById($id);

    if (!$bikeStatusChange) {
      return redirect()->back();
    }

    return view('Admin/BikeStatusChanges/update', [
      'bikeStatusChange' => $bikeStatusChange
    ]);
  }

  public function saveUpdate()
  {
    $post = $this->request->getPost();
    $bikeStatusChange = $this->model->getById($post['id']);
    $bikeStatusChange->date_time = $post['date_time'];
    $bikeStatusChange->temporary = $post['temporary'];

    if ($this->model->save($bikeStatusChange)) {
      return redirect()->to(site_url('Admin/BikeStatusChanges/viewLastSixMonths'));
    } else {
      return redirect()->back();
    }
  }


  public function fetchByPlateNumber()
  {
    $plateNumber = $this->request->getPost('plate_number');
    $statusChanges = $this->model->getStatusHistoryByPlateNumber($plateNumber);
    $statusChangesArray = [];

    foreach ($statusChanges as $statusChange) {

      $statusChangesArray[] = $statusChange;
    }

    return ($this->response->setJSON($statusChangesArray));
  }

  public function getErrors()
  {
    $sqlCustomersNoBike = '
      SELECT *
      FROM customers
      WHERE id
      NOT IN (
        SELECT DISTINCT(customer_id)
        FROM bike_status_change
      )
      AND currently_renting = 1
    ';
    $customersNoBike = $this->db->query($sqlCustomersNoBike)->getResultArray();

    $sqlBikesNotGargeOrCustomer = '
      SELECT plate_number
      FROM bikes
      WHERE plate_number
      NOT IN (
        SELECT plate_number
        FROM bikes
        WHERE sale_date > "2009-01-01"
      ) 
      AND plate_number NOT IN (
        SELECT plate_number
        FROM bike_status_change
        WHERE date_time = (
          SELECT MAX(date_time)
          FROM bike_status_change AS bsc2
          WHERE bsc2.customer_id = bike_status_change.customer_id
        )
        AND customer_id
        IN (
          SELECT id
          FROM customers 
          WHERE currently_renting = 1
        )
      )
      AND plate_number NOT IN (         
        SELECT t2.plate_number
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
                WHERE location = "garage"
            ) OR date IN (
              SELECT MAX(date)
                FROM parked_in_garage
                WHERE location = "home"
            ) OR date IN (
              SELECT MAX(date)
                FROM parked_in_garage
                WHERE location = "sym"
            ) OR date IN (
              SELECT MAX(date)
                FROM parked_in_garage
                WHERE location = "tay"
            )
            )t1              
            GROUP BY plate_number
            )  
            ORDER BY `parked_in_garage`.`date` DESC
            )t2
            ON b.plate_number = t2.plate_number;
        )
      )
    ';
    // $sqlBikesNotGargeOrCustomer = '
    //   SELECT plate_number
    //   FROM bikes
    //   WHERE plate_number
    //   NOT IN (
    //     SELECT plate_number
    //     FROM bikes
    //     WHERE sale_date > "2009-01-01"
    //   ) 
    //   AND plate_number NOT IN (
    //     SELECT plate_number
    //     FROM bike_status_change
    //     WHERE date_time = (
    //       SELECT MAX(date_time)
    //       FROM bike_status_change AS bsc2
    //       WHERE bsc2.customer_id = bike_status_change.customer_id
    //     )
    //     AND customer_id
    //     IN (
    //       SELECT id
    //       FROM customers 
    //       WHERE currently_renting = 1
    //     )
    //   )
    //   AND plate_number NOT IN (
    //     SELECT plate_number
    //     FROM parked_in_garage
    //     WHERE date = (
    //       SELECT MAX(date)
    //       FROM parked_in_garage
    //     )
    //   )
    // ';
    $bikesNotGargeOrCustomer = $this->db->query($sqlBikesNotGargeOrCustomer)->getResultArray();

    $sqlBikesMultipleStatus = '
        SELECT *
        FROM (
        SELECT plate_number, customer_id, new_status
        FROM bike_status_change
        WHERE date_time = (
            SELECT MAX(date_time)
            FROM bike_status_change AS bsc2
            WHERE bsc2.customer_id = bike_status_change.customer_id
        )
        AND customer_id
        IN (
          SELECT id
          FROM customers 
          WHERE currently_renting = 1
        )
        )t1 WHERE EXISTS (
          SELECT 1
          FROM (
            SELECT plate_number, customer_id, new_status
            FROM bike_status_change
            WHERE date_time = (
              SELECT MAX(date_time)
              FROM bike_status_change AS bsc2
              WHERE bsc2.customer_id = bike_status_change.customer_id
          )
          AND customer_id
          IN (
              SELECT id
              FROM customers 
            WHERE currently_renting = 1
          )
        )t2 WHERE t1.plate_number = t2.plate_number
            AND t1.customer_id != t2.customer_id
        )
       ORDER BY plate_number ASC
    ';
    $bikesMultipleStatus = $this->db->query($sqlBikesMultipleStatus)->getResultArray();

    $sqlCustomersBikeInGarage = '
      SELECT customer_id, new_status, plate_number
      FROM bike_status_change
      WHERE date_time = (
          SELECT MAX(date_time)
          FROM bike_status_change AS bsc2
          WHERE bsc2.customer_id = bike_status_change.customer_id
      )
      AND customer_id
      IN (
        SELECT id
        FROM customers 
        WHERE currently_renting = 1
      )
      AND plate_number
      IN (
      SELECT plate_number
      FROM parked_in_garage
      WHERE date = (
        SELECT MAX(date)
        FROM parked_in_garage
      )
      )
    ';
    $customersBikeInGarage = $this->db->query($sqlCustomersBikeInGarage)->getResultArray();

    return view('Admin/BikeStatusChanges/getErrors', [
      'customersNoBike' => $customersNoBike,
      'bikesNotGargeOrCustomer' => $bikesNotGargeOrCustomer,
      'bikesMultipleStatus' => $bikesMultipleStatus,
      'customersBikeInGarage' => $customersBikeInGarage,
    ]);
  }
}
