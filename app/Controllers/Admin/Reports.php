<?php

namespace App\Controllers\Admin;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\AppointmentsModel;
use App\Entities\Appointment;

class Reports extends \App\Controllers\BaseController
{
    public function getTodaysReport()
    {
        $statusChangeModel = new \App\Models\BikeStatusChangeModel;
        $paymentsModel = new \App\Models\PaymentsModel;
        $customersModel = new \App\Models\CustomersModel;

        $todaysStatusChanges = $statusChangeModel->getTodaysRecords();
        $todaysPayments = $paymentsModel->getTodaysRecords();
        $todaysNewCustomers = $customersModel->getTodaysStartRecords();
        $todaysDepartingCustomers = $customersModel->getTodaysEndRecords();

        foreach ($todaysDepartingCustomers as $customer) {
            $currentBike = $statusChangeModel->getCurrentStatus($customer->id);

            if (isset($currentBike)) {
                $customer->current_bike = $currentBike->plate_number;
            } else {
                $customer->current_bike = 'UNKNOWN';
            }
        }

        return view('Admin/Reports/getTodaysReport', [
            'statusChanges' => $todaysStatusChanges,
            'payments' => $todaysPayments,
            'newCustomers' => $todaysNewCustomers,
            'departingCustomers' => $todaysDepartingCustomers,
        ]);
    }

    public function getMaintenanceList()
    {
        $sql = 'SELECT SUBSTRING_INDEX(t1.plate_number, " ", 1) AS plate_number, t1.customer_id, c.customer_name, c.email_address
            FROM ( 
                SELECT * 
            FROM bike_status_change
            WHERE (plate_number, date_time) 
            IN
            (
                SELECT t1.plate_number, MAX(t1.date_time) AS date_time
                FROM
                (
                    SELECT * FROM bike_status_change 
                    WHERE (customer_id, date_time) IN ( 
                        SELECT customer_id, MAX(date_time) AS date_time FROM bike_status_change 
                        WHERE customer_id IN ( 
                            SELECT id FROM customers WHERE currently_renting = 1 
                        ) 
                        GROUP BY customer_id 
                    )
                )t1
                GROUP BY t1.plate_number
            )
                ) t1 JOIN ( 
                    SELECT plate_number, MAX(repair_date) AS repair_date
                    FROM repairs 
                    WHERE nhot = 1 
                    AND plate_number NOT IN ( 
                        SELECT plate_number 
                        FROM bikes 
                        WHERE sale_date > "2000-01-01" 
                    ) 
                    GROUP BY plate_number 
                    HAVING MAX(repair_date) < DATE_SUB(CURRENT_TIMESTAMP(), INTERVAL 3 MONTH) 
                    ORDER BY MAX(repair_date) 
                    ) t2 
                    ON t1.plate_number = t2.plate_number 
                    JOIN customers c on c.id = t1.customer_id  
            -- ORDER BY t1.plate_number
            LIMIT 5
            ';

        $db = db_connect();
        //     $query_result = $db->query('SELECT * FROM bikes');
        //     dd($query_result);

        // $db = db_connect();
        // $sql = 'SELECT id, customer_name, email_address, DATE_ADD(start_date, INTERVAL months_paid MONTH) AS paid_up_to, current_bike,
        // (SELECT repair_date FROM repairs WHERE nhot = 1 AND plate_number = a.current_bike ORDER BY repair_date DESC LIMIT 1) AS last_oil_change,
        // (SELECT total_cost FROM repairs WHERE nhot = 1 AND plate_number = a.current_bike ORDER BY repair_date DESC LIMIT 1) AS last_repair_total
        // FROM (SELECT id, customer_name, email_address, start_date, (SELECT SUM(months_paid) FROM payments
        // WHERE id = c.id) AS months_paid, (SELECT plate_number FROM bike_status_change
        // WHERE id = c.id ORDER BY date_time DESC LIMIT 1) AS current_bike
        // FROM customers c WHERE currently_renting = 1)a ORDER BY paid_up_to DESC';

        return $db->query($sql);
    }

    public function sendEmailsToMaintenanceList()
    {
        require ROOTPATH . '/vendor/PHPMailer-master/src/Exception.php';
        require ROOTPATH . '/vendor/PHPMailer-master/src/PHPMailer.php';
        require ROOTPATH . '/vendor/PHPMailer-master/src/SMTP.php';

        $resultArray = $this->getMaintenanceList()->getResultArray();
        $model = new AppointmentsModel;

        foreach ($resultArray as $row) {
            $name = trim($row['customer_name'], "0..9");
            $email = $row['email_address'];
            $plateNumber = $row['plate_number'];
            $customerID = $row['customer_id'];

            $appointment = new Appointment();
            $appointment->customer_id = $customerID;
            $appointment->customer_name = $name;
            $appointment->current_bike = $plateNumber;
            $appointment->appointment_time = NULL;
            $appointment->startActivation();
            $model->insert($appointment);

            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'mail.saigonbikerentals.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'patrick@saigonbikerentals.com';
            $mail->Password = 'n1FaZ!Sz#)vB';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 26;
            $mail->setFrom('patrick@saigonbikerentals.com');
            // $mail->addAddress($email);
            $mail->addAddress('dragonbiketoursvn@gmail.com'); // send to self first to test
            $mail->isHTML(true);
            $mail->Subject = "Bike Maintenance";

            $link = site_url("Appointments/select/{$appointment->token}");

            $mail->Body = "<p>Hi {$name},</p><p>According to our records, you are 
                    currently renting the bike with plate number <b>
                    {$plateNumber}</b>, which is now due for maintenance. If this 
                    is not the correct bike please reply directly to this email 
                    and let us know. Otherwise, please click on the link below 
                    to schedule a service appointment.</p><p>Best regards,</p>
                    <p>Saigon Bike Rentals</p><p><a href='{$link}'>Book 
                    Appointment</a></p><br><p><strong>PS - THIS IS A NEW 
                    AUTOMATED SCHEDULING SYSTEM I HAVE BEEN WORKING ON SO PLEASE LET ME KNOW IF YOU NOTICE ANY BUGS
                    AS THIS IS STILL IN BETA :)</strong?</p>";

            // $mail->Body = '<p>' . 'Hi ' . $name . ',' . '</p><p>' . 'According to our records, you are currently renting the bike 
            //     with plate number <b>' .
            //     $plateNumber . '</b>, which is due for maintenance. If this is not the correct bike please reply directly to this email
            //     and let us know. Otherwise, please click on the link below to schedule a service appointment.' . '</p><p>' .
            //     'Best regards,' . '</p><p>' . 'Saigon Bike Rentals' . '</p><br><p><strong>PS - THIS IS A NEW 
            //     AUTOMATED SCHEDULING SYSTEM I HAVE BEEN WORKING ON SO PLEASE LET ME KNOW IF YOU NOTICE ANY BUGS
            //     AS THIS IS STILL IN BETA :)</strong?</p>';

            if (!$mail->send()) {

                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {

                $path = '{sng103.hawkhost.com:993/ssl}INBOX.Sent';
                $imapStream = imap_open($path, 'patrick@saigonbikerentals.com', 'n1FaZ!Sz#)vB');
                imap_append($imapStream, $path, $mail->getSentMIMEMessage());
                imap_close($imapStream);
                echo 'Message sent!';
            }
        }
    }
}
