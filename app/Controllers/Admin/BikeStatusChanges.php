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
    SELECT t_unaccounted_bikes.plate_number, last_in_garage, last_service_date, new_status AS last_status, date_time
FROM

(
SELECT bsc.plate_number, bsc.date_time, bsc.new_status
    FROM bike_status_change bsc 
    	JOIN ( 
            SELECT plate_number, MAX(date_time) AS latest_date 
            FROM `bike_status_change` 
            WHERE plate_number NOT IN ( 
                SELECT plate_number 
                FROM bikes 
                WHERE sale_date > "2009-01-01" 
            ) GROUP BY plate_number 
        )t_latest_times 
    	ON bsc.plate_number = t_latest_times.plate_number 
    	AND bsc.date_time = t_latest_times.latest_date
        WHERE bsc.plate_number IN (
        	SELECT plate_number
            FROM repairs 
            WHERE repair_date > "2024-01-01"
        )
        AND bsc.customer_id NOT IN (
        	SELECT id
            FROM customers 
            WHERE currently_renting = 1
        )
        
        UNION
        
        SELECT t_latest_status_changes.plate_number,  t_latest_status_changes.date_time,
		t_latest_status_changes.new_status
		FROM ( 
    		SELECT bsc.date_time, bsc.plate_number, bsc.new_status, bsc.customer_id 
    		FROM bike_status_change bsc 
    	JOIN ( 
            SELECT plate_number, MAX(date_time) AS latest_date 
            FROM `bike_status_change` 
            WHERE plate_number NOT IN ( 
                SELECT plate_number 
                FROM bikes 
                WHERE sale_date > "2009-01-01" 
            ) GROUP BY plate_number 
        )t_latest_times 
    	ON bsc.plate_number = t_latest_times.plate_number 
    	AND bsc.date_time = t_latest_times.latest_date 
	)t_latest_status_changes 
    
    LEFT JOIN ( 
        SELECT pig.plate_number, pig.location, pig.date 
        FROM parked_in_garage pig JOIN ( 
            SELECT location, MAX(date) AS latest_date 
            FROM `parked_in_garage` GROUP BY location 
        )t_latest_dates 
        ON pig.location = t_latest_dates.location 
        AND pig.date = t_latest_dates.latest_date 
        WHERE pig.plate_number != "EMPTY" 
    )t_latest_in_garage 
    ON t_latest_status_changes.plate_number = t_latest_in_garage.plate_number
    WHERE t_latest_status_changes.new_status = "Saigon Bike Rentals"
    AND t_latest_in_garage.location IS NULL
)t_unaccounted_bikes

JOIN

(
SELECT plate_number, MAX(repair_date) AS last_service_date
FROM repairs 
GROUP BY plate_number  
)t_latest_services

ON t_unaccounted_bikes.plate_number = t_latest_services.plate_number

JOIN

(
SELECT plate_number, MAX(date) AS last_in_garage
FROM `parked_in_garage`
GROUP BY plate_number
)t_last_in_garage

ON t_unaccounted_bikes.plate_number = t_last_in_garage.plate_number
    ';
    //     $sqlBikesNotGargeOrCustomer = '
    //       SELECT t3.plate_number, t4.last_in_garage, t4.location, t5.last_service_date, t6.last_status, t6.date_time
    //       FROM (
    //         SELECT plate_number
    //         FROM bikes
    //         WHERE plate_number
    //         NOT IN (
    //           SELECT plate_number
    //           FROM bikes
    //           WHERE sale_date > "2009-01-01"
    //         ) 
    //         AND plate_number NOT IN (
    //           SELECT plate_number
    //           FROM bike_status_change
    //           WHERE date_time = (
    //             SELECT MAX(date_time)
    //             FROM bike_status_change AS bsc2
    //             WHERE bsc2.customer_id = bike_status_change.customer_id
    //           )
    //           AND customer_id
    //           IN (
    //             SELECT id
    //             FROM customers 
    //             WHERE currently_renting = 1
    //           )
    //         )
    //         AND plate_number NOT IN (

    //         SELECT t2.plate_number
    //               FROM bikes b
    //               JOIN (
    //               SELECT plate_number, date, location
    //               FROM parked_in_garage
    //               WHERE (plate_number, date)
    //               IN (
    //               SELECT plate_number, MAX(date) AS date
    //               FROM (
    //               SELECT *
    //               FROM parked_in_garage 
    //               WHERE date IN (
    //                 SELECT MAX(date)
    //                   FROM parked_in_garage
    //                   WHERE location = "garage"
    //               ) OR date IN (
    //                 SELECT MAX(date)
    //                   FROM parked_in_garage
    //                   WHERE location = "home"
    //               ) OR date IN (
    //                 SELECT MAX(date)
    //                   FROM parked_in_garage
    //                   WHERE location = "sym"
    //               ) OR date IN (
    //                 SELECT MAX(date)
    //                   FROM parked_in_garage
    //                   WHERE location = "tay"
    //               )
    //             )t1

    //             GROUP BY plate_number
    //             )  
    //             ORDER BY `parked_in_garage`.`date` DESC
    //             )t2
    //             ON b.plate_number = t2.plate_number
    //       )
    // )t3 LEFT JOIN (
    // SELECT plate_number, date AS last_in_garage, location 
    // FROM parked_in_garage 
    // WHERE (plate_number, date)
    // IN (
    // 	SELECT plate_number, MAX(date) AS last_in_garage 
    // 	FROM parked_in_garage
    // 	GROUP BY plate_number
    // )
    // )t4 ON t3.plate_number = t4.plate_number
    // LEFT JOIN (
    // 	SELECT plate_number, MAX(repair_date) AS last_service_date
    // FROM repairs 
    // GROUP BY plate_number
    // )t5 ON t3.plate_number = t5.plate_number
    // LEFT JOIN (

    //     SELECT plate_number, new_status AS last_status, date_time
    // FROM bike_status_change
    // WHERE (plate_number, date_time)
    // IN (
    // SELECT plate_number, MAX(date_time) AS last_status_change
    // FROM bike_status_change 
    // GROUP BY plate_number
    // )   

    // )t6 ON t3.plate_number = t6.plate_number
    //     ';
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

    // 	SELECT t2.plate_number
    //         FROM bikes b
    //         JOIN (
    //         SELECT plate_number, date, location
    //         FROM parked_in_garage
    //         WHERE (plate_number, date)
    //         IN (
    //         SELECT plate_number, MAX(date) AS date
    //         FROM (
    //         SELECT *
    //         FROM parked_in_garage 
    //         WHERE date IN (
    //           SELECT MAX(date)
    //             FROM parked_in_garage
    //             WHERE location = "garage"
    //         ) OR date IN (
    //           SELECT MAX(date)
    //             FROM parked_in_garage
    //             WHERE location = "home"
    //         ) OR date IN (
    //           SELECT MAX(date)
    //             FROM parked_in_garage
    //             WHERE location = "sym"
    //         ) OR date IN (
    //           SELECT MAX(date)
    //             FROM parked_in_garage
    //             WHERE location = "tay"
    //         )
    //         )t1

    //         GROUP BY plate_number
    //         )  
    //         ORDER BY `parked_in_garage`.`date` DESC
    //         )t2
    //         ON b.plate_number = t2.plate_number
    //   )
    // ';
    // $sqlBikesNotGargeOrCustomer = '
    // SELECT plate_number
    // FROM bikes
    // WHERE plate_number
    // NOT IN (
    //   SELECT plate_number
    //   FROM bikes
    //   WHERE sale_date > "2009-01-01"
    // ) 
    // AND plate_number NOT IN (
    //   SELECT plate_number
    //   FROM bike_status_change
    //   WHERE date_time = (
    //     SELECT MAX(date_time)
    //     FROM bike_status_change AS bsc2
    //     WHERE bsc2.customer_id = bike_status_change.customer_id
    //   )
    //   AND customer_id
    //   IN (
    //     SELECT id
    //     FROM customers 
    //     WHERE currently_renting = 1
    //   )
    // )
    // AND plate_number NOT IN (
    //   SELECT plate_number
    //   FROM parked_in_garage
    //   WHERE date = (
    //     SELECT MAX(date)
    //     FROM parked_in_garage
    //   )
    // )
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
            ON b.plate_number = t2.plate_number
      
      )
    ';
    // $sqlCustomersBikeInGarage = '
    //   SELECT customer_id, new_status, plate_number
    //   FROM bike_status_change
    //   WHERE date_time = (
    //       SELECT MAX(date_time)
    //       FROM bike_status_change AS bsc2
    //       WHERE bsc2.customer_id = bike_status_change.customer_id
    //   )
    //   AND customer_id
    //   IN (
    //     SELECT id
    //     FROM customers 
    //     WHERE currently_renting = 1
    //   )
    //   AND plate_number
    //   IN (
    //   SELECT plate_number
    //   FROM parked_in_garage
    //   WHERE date = (
    //     SELECT MAX(date)
    //     FROM parked_in_garage
    //   )
    //   )
    // ';
    $customersBikeInGarage = $this->db->query($sqlCustomersBikeInGarage)->getResultArray();

    return view('Admin/BikeStatusChanges/getErrors', [
      'customersNoBike' => $customersNoBike,
      'bikesNotGargeOrCustomer' => $bikesNotGargeOrCustomer,
      'bikesMultipleStatus' => $bikesMultipleStatus,
      'customersBikeInGarage' => $customersBikeInGarage,
    ]);
  }
}
