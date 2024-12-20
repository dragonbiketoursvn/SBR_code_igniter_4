<?php

namespace App\Controllers\Admin;

use App\Entities\Customer;
use App\Entities\Payment;
use App\Entities\Expense;
use App\Entities\RenterIncident;

use CodeIgniter\I18n\Time;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Customers extends \App\Controllers\BaseController
{
  private $model;
  private $bikesModel;
  private $bikeStatusChangeModel;
  private $compensationTicketsModel;
  private $compensationPaymentsModel;
  private $db;
  private $currentBikes;


  public function __construct()
  {
    $this->model = new \App\Models\CustomersModel;
    $this->bikesModel = new \App\Models\BikesModel;
    $this->bikeStatusChangeModel = new \App\Models\BikeStatusChangeModel;
    $this->compensationTicketsModel = new \App\Models\CompensationTicketsModel;
    $this->compensationPaymentsModel = new \App\Models\CompensationPaymentsModel;
    $this->db = \Config\Database::connect();

    $this->currentBikes = $this->bikesModel->getCurrentBikes();
  }

  public function selectContractType()
  {
    return view('Admin/Customers/selectContractType');
  }

  public function queryExchangeRateAPI()
  {
    if (true) {
      $FIXER_API_BASE = "http://data.fixer.io/api/";
      $FIXER_API_KEY = "1eab7800720a67d57ee29ae5dd6ca378";
      $EUR_TO_USD = null;
      $EUR_TO_VND = null;

      $url = "{$FIXER_API_BASE}latest?access_key={$FIXER_API_KEY}&symbols=USD,VND";

      $curl = curl_init(); // initializes cURL session and returns handle
      curl_setopt($curl, CURLOPT_URL, $url); // sets the URL to be accessed
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // transfers return value of curl_exec() as a string

      $resp = curl_exec($curl); // sends the request
      $val = json_decode($resp, $associative = true, $depth = 512);

      foreach ($val as $item) {
        if (is_array($item)) {
          // echo $key . "=>" . implode(": ", $item) . "\n";
          $pre_array = implode(":", $item);
          $array = explode(":", $pre_array);
          $EUR_TO_USD = $array[0];
          $EUR_TO_VND = $array[1];
          $USD_TO_VND = (1 / $EUR_TO_USD) * $EUR_TO_VND;
          $sql = "INSERT INTO usd_vnd_exchange_rate(date, price)
                VALUES (CURRENT_DATE(), {$USD_TO_VND})";
          $this->db->query($sql);
        }
      }
    }
  }

  private function getExchangeRates()
  {
    $sql = "
            SELECT price
            FROM `usd_vnd_exchange_rate`
            ORDER BY id DESC
            LIMIT 1
          ";

    $USD_TO_VND = (float) $this->db->query($sql)->getResult()[0]->price;
    $VND_TO_USD = 1 / $USD_TO_VND;
    return [$USD_TO_VND, $VND_TO_USD];
  }

  public function newContract()
  {
    $nationalities = $this->model->select('nationality')->distinct()->findAll();
    // $model = new \App\Models\BikesModel;

    [$USD_TO_VND, $VND_TO_USD] = $this->getExchangeRates();

    return view('Admin/Customers/newContract', [
      'nationalities' => $nationalities,
      'currentBikes' => $this->currentBikes,
      'USD_TO_VND' => $USD_TO_VND,
      'VND_TO_USD' => $VND_TO_USD
    ]);
  }

  public function newContractShort()
  {
    $nationalities = $this->model->select('nationality')->distinct()->findAll();
    // $model = new \App\Models\BikesModel;

    [$USD_TO_VND, $VND_TO_USD] = $this->getExchangeRates();

    return view('Admin/Customers/newContractShort', [
      'nationalities' => $nationalities,
      'currentBikes' => $this->currentBikes,
      'USD_TO_VND' => $USD_TO_VND,
      'VND_TO_USD' => $VND_TO_USD
    ]);
  }

  private function getModelYearCode($plateNumber)
  {
    $sql = "SELECT myc.code 
            FROM bikes b 
            JOIN model_year_codes myc
            ON (b.model = myc.model AND b.year = myc.year)
            WHERE b.plate_number = '{$plateNumber}'";

    return $this->db->query($sql)->getRow()->code;
  }

  public function save()
  {
    $plateNumbers = [];

    foreach ($this->currentBikes as $bike) {
      $plateNumbers[] = $bike->plate_number;
    };

    $post = $this->request->getPost();
    [$USD_TO_VND, $VND_TO_USD] = $this->getExchangeRates();

    $customer = new Customer;
    $customer->fill($post);

    // $customer->rent_usd = $customer->rent_usd + $customer->damage_insurance_amount;
    // $customer->rent = (int) ($customer->rent_usd * $USD_TO_VND / 1000);
    // $customer->paypal_deposit = $post['paypal_deposit'];
    // $customer->expected_total_vnd = (int) (($customer->rent_usd - $customer->paypal_deposit) * $USD_TO_VND / 1000);

    $customer->currently_renting = 1;

    if (!in_array($customer->current_bike, $plateNumbers)) {
      session()->set('errors', ['Plate Number Not Found']);
      return redirect()->back()->withInput();
    }

    $customer->model_year_code = $this->getModelYearCode($customer->current_bike);

    // Get all the uploaded files
    $files = $this->request->getFiles();

    //LOOP THROUGH THE FILES ARRAY, GETTING THE KEY FOR EACH INDEX SO WE CAN USE IT TO CREATE THE CORRECT FOLDER FOR EACH UPLOADED FILE
    foreach ($files as $key => $file) {

      // ALL INPUTS ARE NOT REQUIRED SO WE CHECK THAT FILE SIZE IS GREATER THAN ZERO TO DETERMINE WHETHER THERE'S ACTUALLY A FILE AT EACH INDEX
      if ($file->getSizeByUnit('mb' > 0)) {

        // CHECK VALIDITY
        if (!$file->isValid()) {

          $error_code = $file->getError();
          throw new \RuntimeException($file->getErrorString() . " " . $error_code);
        }

        // CHECK FILE SIZE TO MAKE SURE IT DOESN'T EXCEED OUR MAX ALLOWED SIZE
        $size = $file->getSizeByUnit('mb');

        if ($size > 5) {

          return redirect()->back()
            ->with('warning', 'File too large (max 5MB)');
        }

        $type = $file->getMimeType();

        if (!in_array($type, ['image/png', 'image/jpeg'])) {

          return redirect()->back()
            ->with('warning', 'Invalid file format (PNG or JPEG only)');
        }

        // Store it in the 'writable/uploads/images' folder
        $file->store('renter_docs/');

        // Add path to correct customer entity property
        $customer->$key = $file->getName();
      }
    }

    // Now start activation process
    $customer->startActivation();

    //Get list of all Dragon Bikes from BikesModel, put plate numbers in an array, and check whether customer's bike is in this array
    // $model = new \App\Models\BikesModel;
    $dragonBikes = $this->bikesModel->getDragonBikes();
    $dragonBikesPlateNumbers = [];

    foreach ($dragonBikes as $dragonBike) {

      $dragonBikesPlateNumbers[] = $dragonBike->plate_number;
    }

    if (in_array($customer->current_bike, $dragonBikesPlateNumbers)) {

      $customer->dragon_bikes = 1;
    }

    if ($this->model->insert($customer)) {

      // Get record of rental bike
      // $bikesModel = new \App\Models\BikesModel;
      $bike = $this->bikesModel->getBikeByPlateNumber($customer->current_bike);

      // Pass all info from contract to use in activation email (monthly renters only)
      if ($customer->short_term !== "1") {

        // Get bike's current market value
        $bikeValuationsModel = new \App\Models\BikeValuationsModel;
        $valuationRecord = $bikeValuationsModel->getValueByModelAndYear($bike->model, $bike->year);

        // Format the value
        $value = number_format($valuationRecord->value * 1000, 0, '.', ',');

        $this->sendActivationEmail($customer, $bike, $value);
      }

      // better if we get the new customer's id!!
      // Get new customer record
      // $newCustomer = $this->model->getCurrentCustomerByName($customer->customer_name);
      $newCustomer = $this->model->getLatestRecord();

      // Now use new customer record together with original entity to create bike_status_change record
      // $statusChangeModel = new \App\Models\BikeStatusChangeModel;
      // $statusChangeModel = $this->bikeStatusChangeModel;
      $bikeStatusChange = new \App\Entities\BikeStatusChange;

      $bikeStatusChange->user = 'ADMIN';
      $bikeStatusChange->plate_number = $customer->current_bike;
      $bikeStatusChange->date_time = $customer->start_date;
      $bikeStatusChange->new_status = $customer->customer_name;
      $bikeStatusChange->customer_id = $newCustomer->id;

      $this->bikeStatusChangeModel->insert($bikeStatusChange);

      // If this is a short-term rental, the one and only rental payment will be made at pick up
      // so this can be integrated into contract creation

      if ($newCustomer->short_term === '1') {
        $paymentsModel = new \App\Models\PaymentsModel;
        $expensesModel = new \App\Models\ExpensesModel;
        $payment = new \App\Entities\Payment;
        $expense = new \App\Entities\Expense;



        // $payment_rent_usd = $customer->rent_usd + $customer->damage_insurance_amount; // short-term
        // $customer->rent = (int) ($customer->rent_usd * $USD_TO_VND / 1000); // short-term
        // $customer->paypal_deposit = $post['paypal_deposit']; // short-term
        // $customer->expected_total_vnd = (int) (($payment_rent_usd - $customer->paypal_deposit) * $USD_TO_VND / 1000); // short-term
        // $customer->actual_total_vnd = $post['actual_total_vnd']; // short-term
        // $customer->deposit_returned_vnd = $post['deposit_returned_vnd']; // short-term
        // $customer->cash_received_vnd_value = $post['cash_received_vnd_value']; // short-term


        $payment->customer_id = $newCustomer->id;
        $payment->amount_usd = $newCustomer->rent_usd + $newCustomer->damage_insurance_amount; // add damage insurance to total
        $payment->amount = (int) ($payment->amount_usd * $USD_TO_VND / 1000); // vnd amount of rent + damage insurance
        $payment->months_paid = 0;
        $payment->user = 'ADMIN';
        $payment->payment_date = $newCustomer->start_date;
        $payment->payment_method = $post["payment_method"];
        $payment->paypal_deposit = $post['paypal_deposit'];
        $payment->expected_total_vnd = (int) (($payment->amount_usd - $payment->paypal_deposit) * $USD_TO_VND / 1000);
        $payment->actual_total_vnd = $post['actual_total_vnd'];
        $payment->deposit_returned_vnd = $post['deposit_returned_vnd'];
        // $payment->cash_received_vnd_value = $post['cash_received_vnd_value'];
        $paymentsModel->insert($payment);
        $newPayment = $paymentsModel->getLatestRecord();

        if ($payment->actual_total_vnd > 0 && $payment->deposit_returned_vnd > 0) {
          $expense->user = 'super';
          $expense->date = $newPayment->payment_date;
          $expense->amount = $newPayment->expected_total_vnd -
            ($newPayment->actual_total_vnd - $newPayment->deposit_returned_vnd);
          $expense->category = 'bank transfer fee';
          $expense->notes = $newPayment->id;
          $expense->dragon_bikes = 1;
          $expensesModel->insert($expense);
        }
      }

      return redirect()->to(site_url('Admin/Home'));
    } else {

      return redirect()->back()->with('errors', $this->model->errors())->withInput();
    }
  }

  public function update()
  {
    [$USD_TO_VND, $VND_TO_USD] = $this->getExchangeRates();

    // Get all suitable values from $_POST and assign to a new Customer entity
    $post = $this->request->getPost();
    $customer = new Customer;
    $customer->fill($post);

    // If a value has been added for finish_date and `short_term` isn't true then this customer is no longer renting
    if (
      $this->request->getPost('finish_date') > '2000-01-01'
      && $customer->short_term === '0'
    ) {
      $customer->currently_renting = '0';
    }

    // Now get all the uploaded files
    $files = $this->request->getFiles();

    //LOOP THROUGH THE FILES ARRAY, GETTING THE KEY FOR EACH INDEX SO WE CAN USE IT TO CREATE THE CORRECT FOLDER FOR EACH UPLOADED FILE
    foreach ($files as $key => $file) {

      // ALL INPUTS ARE NOT REQUIRED SO WE CHECK THAT FILE SIZE IS GREATER THAN ZERO TO DETERMINE WHETHER THERE'S ACTUALLY A FILE AT EACH INDEX
      if ($file->getSizeByUnit('mb' > 0)) {

        // CHECK VALIDITY
        if (!$file->isValid()) {

          $error_code = $file->getError();
          throw new \RuntimeException($file->getErrorString() . " " . $error_code);
        }

        // CHECK FILE SIZE TO MAKE SURE IT DOESN'T EXCEED OUR MAX ALLOWED SIZE
        $size = $file->getSizeByUnit('mb');

        if ($size > 5) {

          return redirect()->back()
            ->with('warning', 'File too large (max 5MB)');
        }

        $type = $file->getMimeType();

        if (!in_array($type, ['image/png', 'image/jpeg'])) {

          return redirect()->back()
            ->with('warning', 'Invalid file format (PNG or JPEG only)');
        }

        // Store it in the 'writable/uploads/images' folder
        $file->store('renter_docs/');

        // Add path to correct customer entity property
        $customer->$key = $file->getName();
      }
    }

    // At this point all values and files have been added to the record and we can save it, going to
    // viewCurrentCustomers if successful or otherwise redirecting back so the user can fix any errors
    if ($this->model->skipValidation(true)->save($customer)) {

      // If customer is no longer renting so bike's status must be changed to SBR
      if ($customer->currently_renting === '0') {
        // $statusChangeModel = new \App\Models\BikeStatusChangeModel;
        $bikeStatusChange = new \App\Entities\BikeStatusChange;

        $bikeStatusChange->user = 'ADMIN';
        // $bikeStatusChange->plate_number = $statusChangeModel
        //   ->getCurrentStatus($customer->id)
        //   ->plate_number;
        $bikeStatusChange->plate_number = $customer->current_bike;
        $bikeStatusChange->date_time = $customer->finish_date;
        $bikeStatusChange->new_status = 'Saigon Bike Rentals';
        $this->bikeStatusChangeModel->insert($bikeStatusChange);
      }

      // If customer is short-term we need to update the payment and/or expense 
      // records in case the amount has changed
      // also update bike_status_change record if necessary
      if ($customer->short_term === '1') {
        $paymentsModel = new \App\Models\PaymentsModel;
        $expensesModel = new \App\Models\ExpensesModel;

        $bikeStatusChange = $this->bikeStatusChangeModel->getByCustomerId($customer->id)[0];
        $bikeStatusChange->plate_number = $customer->current_bike;

        if ($bikeStatusChange->hasChanged()) {
          $this->bikeStatusChangeModel->save($bikeStatusChange);
        }

        // any new values for fields in payment record should be saved
        // but this must be an update and not insertion of new record
        $oldPayment = $paymentsModel->getByContractNumber($customer->id)[0];

        // post['id'] is the customer id so we need to grab the payment id
        // before filling it with values from post
        $paymentId = $oldPayment->id;
        $oldPayment->fill($post);
        $oldPayment->id = $paymentId;
        $oldPayment->amount_usd = $oldPayment->rent_usd + $oldPayment->damage_insurance_amount;
        $oldPayment->amount = (int) ($oldPayment->amount_usd * $USD_TO_VND / 1000);
        $oldPayment->expected_total_vnd = (int) (($oldPayment->amount_usd - $oldPayment->paypal_deposit) * $USD_TO_VND / 1000);
        // $oldPayment->amount = $oldPayment->rent;
        $expense = $expensesModel->getByNotes($paymentId) ?? new Expense;
        $expense->user = 'super';
        $expense->date = $oldPayment->payment_date;
        $expense->notes = $oldPayment->id;
        $expense->dragon_bikes = 1;

        if ($oldPayment->hasChanged()) {
          if ($oldPayment->actual_total_vnd > 0 && $oldPayment->deposit_returned_vnd > 0) {
            $expense->amount = $oldPayment->expected_total_vnd -
              ($oldPayment->actual_total_vnd - $oldPayment->deposit_returned_vnd);
            // dd([
            //   'official_payment_amount' => $oldPayment->amount,
            //   'expected_total_vnd' => $oldPayment->expected_total_vnd,
            //   'actual_amount_received' => $oldPayment->actual_total_vnd,
            //   'deposit_returned_vnd' => $oldPayment->deposit_returned_vnd,
            //   'transfer fee' => $oldPayment->expected_total_vnd -
            //     ($oldPayment->actual_total_vnd - $oldPayment->deposit_returned_vnd),
            //   'string subtraction result' => ($oldPayment->actual_total_vnd - $oldPayment->deposit_returned_vnd)
            // ]);
            $expense->category = 'bank transfer fee';
            $expensesModel->save($expense);
          }
          $paymentsModel->save($oldPayment);
          // dd($oldPayment->actual_total_vnd);

          // $expensesModel->save($expense);
        }




        // $customer = new Customer;
        // $customer->fill($post);
        // $customer->rent_usd = $customer->rent_usd + $customer->damage_insurance_amount;
        // $customer->rent = (int) ($customer->rent_usd * $USD_TO_VND / 1000);
        // $customer->paypal_deposit = $post['paypal_deposit'];
        // $customer->expected_total_vnd = (int) (($customer->rent_usd - $customer->paypal_deposit) * $USD_TO_VND / 1000);
        // $customer->actual_total_vnd = $post['actual_total_vnd'];
        // $customer->deposit_returned_vnd = $post['deposit_returned_vnd'];
        // $customer->cash_received_vnd_value = $post['cash_received_vnd_value'];
        // $customer->currently_renting = 1;
      }

      $redirectView = $customer->short_term ? 'Admin/Customers/viewCurrentCustomersShortTerm' : 'Admin/Customers/viewCurrentCustomers';

      return redirect()->to(site_url($redirectView));
    } else {

      return redirect()->back()->with('errors', $this->model->errors())->withInput();
    }
  }

  public function activate($token)
  {
    $model = new \App\Models\CustomersModel;
    $customer = $model->activateByToken($token);

    return view('Admin/Customers/activated');
  }

  private function sendActivationEmail($customer, $bike, $value)
  {
    require ROOTPATH . '/vendor/PHPMailer-master/src/Exception.php';
    require ROOTPATH . '/vendor/PHPMailer-master/src/PHPMailer.php';
    require ROOTPATH . '/vendor/PHPMailer-master/src/SMTP.php';

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'mail.saigonbikerentals.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'patrick@saigonbikerentals.com';
    $mail->Password = 'n1FaZ!Sz#)vB';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 26;
    $mail->setFrom('patrick@saigonbikerentals.com');
    $mail->addAddress($customer->email_address);
    $mail->isHTML(true);
    $mail->Subject = 'Rental Agreement';
    $mail->addAttachment(WRITEPATH . 'uploads/registration_cards/' . $bike->reg_front);
    $mail->addAttachment(WRITEPATH . 'uploads/registration_cards/' . $bike->reg_back);
    $mail->Body = '<h1>SAIGON BIKE RENTALS</h1>
      <h2>MOTORBIKE RENTAL CONTRACT</h2>


      <h3>A> Customer information:</h3>

      <ul>
        <li><b>Full name: </b>' . $customer->customer_name . '</li>
        <li><b>Nationality: </b>' . $customer->nationality . '</li>
        <li><b>Mobile: </b>' . $customer->phone_number . '</li>
        <li><b>Email: </b>' . $customer->email_address . '</li>
        <li><b>Deposit Type: </b>' . $customer->deposit_type . '</li>
      </ul>

      <p>
        <u>' . $customer->customer_name . '</u> agrees to rent one ' . $bike->year . ' ' . $bike->brand . ' ' . $bike->model .
      ' with license plate number: <u>' . $customer->current_bike . '</u> , from
        Tran Thi Thu Nga/Saigon Bike Rentals, located at 182/5A Đề Thám in
        District 1 , Ho Chi Minh City starting from <u>' . $customer->start_date . '</u>.
      </p>

      <p>
        The agreed monthly rental fee is <u>' . number_format($customer->rent * 1000, 0, '.', ',') . '</u> VND/month and the monthly rental payment is due on day <u>'
      . substr($customer->start_date, -2) . '</u> of each month.
      </p>


      <h3>B> Customer obligations:</h3>

      <p>
        Motorbike must be returned undamaged (customer may check the bike before signing the contract).
        After taking possession of the motorbike, customer is responsible for taking care of the bike and must
        abide by the following conditions:
      </p>

      <ul>
        <li><b>DO NOT ALLOW ANY REPAIRS TO BE DONE WITHOUT FIRST CONTACTING SAIGON BIKE RENTALS!</b></li>
        <li style="color: tomato;"><b>DON’T <u>EVER</u> LEAVE THE BIKE UNATTENDED UNLESS IT IS IN A SECURE PARKING
        AREA OR LOCKED INSIDE A PRIVATE HOME. IF YOU LEAVE IT OUTSIDE ‘JUST FOR
        A FEW MINUTES’ IT <u>WILL</u> GET STOLEN AND YOU <u>WILL</u> PAY US FOR A
        REPLACEMENT BIKE.</b></li>
        <li><b>DO NOT RIDE THE BIKE AFTER CONSUMING ALCOHOL. VIETNAMESE LAW
        CONSIDERS YOU IMPAIRED WITH ANY ALCOHOL IN YOUR SYSTEM!</b></li>
        <li><b>Do not allow anyone else to drive the motorbike.</b></li>
        <li><b>If the bike is damaged in any way, customer must pay the full cost of repairs.</b></li>
        <li><b>If the bike is lost or damaged beyond repair, customer must pay a replacement charge of <u>' . $value . '</u> dong.</b></li>
        <li><b>If customer does not have a valid motorbike license and the bike is impounded by the police, customer must pay
          <u>all</u> fines imposed, <u>including</u> any fine imposed on the owner of the bike (Saigon Bike Rentals) for allowing
          an unlicensed rider to operate it</b></li>
      </ul>


      <h3>C> Customer rights:</h3>

      <ul>
        <li><b>Free repair (by Saigon Bike Rentals) of any mechanical problems that arise during the rental period.</b></li>
        <li><b>Instruction and assistance on use of motorbike.</b></li>
        <li><b>Assistance in obtaining a Vietnamese motorbike license if customer does not already have one</b></li>
      </ul>




      <h3>D> Customer pledge:</h3>

      <p>
        After reading this contract, I <u>' . $customer->customer_name . '</u> agree to abide by all its terms and conditions and
        agree to be held fully responsible for any violations thereof.
      </p>

      <p>
        <a href="' . site_url("Admin/Customers/activate/{$customer->token}") . '"><button>Click Here to Confirm Your Agreement</button></a>
      </p>';

    if (!$mail->send()) {

      echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {

      $path = '{sng103.hawkhost.com:993/ssl}INBOX.Sent';
      $imapStream = imap_open($path, 'patrick@saigonbikerentals.com', 'n1FaZ!Sz#)vB');
      imap_append($imapStream, $path, $mail->getSentMIMEMessage());
      imap_close($imapStream);
      return redirect()->to(site_url('Admin/Home'))->with('message', 'Message sent!');
    }
  }

  public function  getInfo()
  {
    $customers = $this->model->getCurrentCustomers();
    return view('Admin/Customers/getInfo', ['customers' => $customers]);
  }

  public function emailsAsJSON()
  {
    $customers = $this->model->getCurrentCustomers();
    $customerEmails = [];

    foreach ($customers as $customer) {
      $customerEmails[$customer->customer_name] = $customer->email_address;
    }

    return $this->response->setJSON($customerEmails);
  }

  public function viewInfo()
  {
    if (!$this->request->getPost('customer_name') || !$this->request->getPost('id')) {
      return redirect()->back();
    }

    $customer = $this->model->getCustomerByID($this->request->getPost('id'));
    $compensationTicket = $this->compensationTicketsModel->getActiveTicketsByCustomerId($customer->id);

    $paymentsModel = new \App\Models\PaymentsModel;
    $currentStatus = $this->bikeStatusChangeModel->getCurrentStatus($customer->id);
    $payments = $paymentsModel->getByContractNumber($customer->id);
    $monthsPaid = $paymentsModel->getTotalMonthsPaid($customer->id)->months_paid ?? 0;
    $startDate = new Time();
    $startDate = $startDate->createFromFormat('Y-m-d', $customer->start_date);
    $paidUpTo = $startDate->addMonths($monthsPaid)->toDateString();
    [$USD_TO_VND, $VND_TO_USD] = $this->getExchangeRates();
    $bikeStatusChanges = $this->bikeStatusChangeModel->getByCustomerId($customer->id);

    if ($compensationTicket) {
      $compensationTicket->paidToDate = $this->compensationPaymentsModel
        ->getTotalPaidOnTicket($compensationTicket->id)[0]->amount;
      $compensationTicket->amountOutstanding =
        $compensationTicket->cost_incurred - $compensationTicket->paidToDate;
    }

    return view('Admin/Customers/viewInfo', [
      'customer' => $customer,
      'currentStatus' => $currentStatus,
      'currentBikes' => $this->currentBikes,
      'payments' => $payments,
      'paidUpTo' => $paidUpTo,
      'USD_TO_VND' => $USD_TO_VND,
      'VND_TO_USD' => $VND_TO_USD,
      'bikeStatusChanges' => $bikeStatusChanges,
      'compensationTicket' => $compensationTicket
    ]);
  }

  public function  viewCurrentCustomers()
  {
    $paymentsModel = new \App\Models\PaymentsModel;

    $customers = $this->model->getCurrentCustomers();
    $currentCustomerCount = count($customers);
    $customersOweMoney = $this->model->getFormerCustomersOweMoney();
    $customersOweMoneyCount = count($customersOweMoney);
    $compensationTicketsQueryResult = $this->compensationTicketsModel->getCustomerIdsWithActiveTickets();
    $customerIdsCompensation = [];
    foreach ($compensationTicketsQueryResult as $customerId) {
      $customerIdsCompensation[] = $customerId->customer_id;
    }

    foreach ($customers as $customer) {
      $monthsPaid = $paymentsModel->getTotalMonthsPaid($customer->id)->months_paid ?? 0;
      $startDate = new Time();
      $startDate = $startDate->createFromFormat('Y-m-d', $customer->start_date);
      $paidUpTo = $startDate->addMonths($monthsPaid)->toDateString();
      $payments = $paymentsModel->getByContractNumber($customer->id);

      $customer->paid_up_to = $paidUpTo;
      if (count($payments) > 0) {
        $customer->last_payment = $payments[0]->payment_date;
      }
    }

    usort($customers, function ($customerA, $customerB) {
      if ($customerA->paid_up_to == $customerB->paid_up_to) {
        return 0;
      }
      return ($customerA->paid_up_to < $customerB->paid_up_to) ? -1 : 1;
    });

    $customers = array_merge($customersOweMoney, $customers);

    return view('Admin/Customers/viewCurrentCustomers', [
      'customers' => $customers,
      'currentCustomerCount' => $currentCustomerCount,
      'customersOweMoneyCount' => $customersOweMoneyCount,
      'customerIdsCompensation' => $customerIdsCompensation
    ]);
  }

  public function  viewCurrentCustomersShortTerm()
  {
    $paymentsModel = new \App\Models\PaymentsModel;
    $customers = $this->model->getCurrentCustomersShortTerm();

    foreach ($customers as $customer) {
      $startDate = new Time();
      $startDate = $startDate->createFromFormat('Y-m-d', $customer->start_date);
      $payments = $paymentsModel->getByContractNumber($customer->id);
    }

    usort($customers, function ($customerA, $customerB) {
      if ($customerA->finish_date == $customerB->finish_date) {
        return 0;
      }
      return ($customerA->finish_date < $customerB->finish_date) ? -1 : 1;
    });

    return view('Admin/Customers/viewCurrentCustomersShortTerm', ['customers' => $customers]);
  }

  public function  viewAllCustomers()
  {
    $customers = $this->model->getAllCustomers();

    return view('Admin/Customers/viewAllCustomers', ['customers' => $customers]);
  }

  public function selectCustomerView()
  {
    return view('Admin/Customers/selectCustomerView');
  }

  // Displays photo at $path if it exists
  public function displayCustomerPhoto($path)
  {
    $path = WRITEPATH . 'uploads/renter_docs/' . $path;

    // Since we don't erase the $customer->path property when deleting images from the server we need to check if there's still
    // a file located at $path
    if (is_file($path)) {

      $finfo = new \finfo(FILEINFO_MIME);

      $type = $finfo->file($path);

      header("Content-Type: $type");
      header("Content-Length: " . filesize($path));

      readfile($path);
    }

    exit;
  }

  // Deletes photo from writable directory if it exists
  public function deleteCustomerPhoto($path)
  {
    $path = WRITEPATH . 'uploads/renter_docs/' . $path;

    if (is_file($path)) {
      unlink($path);
    }
  }

  public function contactCustomers()
  {
    return view('Admin/Customers/contactCustomers');
  }

  public function broadcastMessage()
  {
    $post = $this->request->getPost();
    $customers = null;
    $subject = null;
    $subject = $post['subject'];
    $message = $post['message'];

    if ($post['selection'] === 'monthly') {
      $customers = $this->model->getCurrentCustomersMonthly();
    } else {
      $customers = $this->model->getCurrentCustomersShortTerm();
    }

    if ($this->sendBroadcastEmail($customers, $subject, $message)) {
      return redirect()->to(site_url('Admin/Home'))->with('message', 'Message sent!');
    };
  }

  private function sendBroadcastEmail($customers, $subject, $message)
  {
    require ROOTPATH . '/vendor/PHPMailer-master/src/Exception.php';
    require ROOTPATH . '/vendor/PHPMailer-master/src/PHPMailer.php';
    require ROOTPATH . '/vendor/PHPMailer-master/src/SMTP.php';

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'mail.saigonbikerentals.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'patrick@saigonbikerentals.com';
    $mail->Password = 'n1FaZ!Sz#)vB';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 26;
    $mail->setFrom('patrick@saigonbikerentals.com');

    foreach ($customers as $customer) {
      $mail->addBCC($customer->email_address);
    }

    $mail->isHTML(false);
    $mail->Subject = $subject;
    $mail->Body = $message;

    if (!$mail->send()) {

      echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {

      $path = '{sng103.hawkhost.com:993/ssl}INBOX.Sent';
      $imapStream = imap_open($path, 'patrick@saigonbikerentals.com', 'n1FaZ!Sz#)vB');
      imap_append($imapStream, $path, $mail->getSentMIMEMessage());
      imap_close($imapStream);
      return true;
    }
  }
}
