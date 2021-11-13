<?php

namespace App\Controllers\Admin;

use App\Entities\Customer;
use App\Entities\RenterIncident;

use CodeIgniter\I18n\Time;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Customers extends \App\Controllers\BaseController
{
  private $model;

  public function __construct()
  {
    $this->model = new \App\Models\CustomersModel;
  }

  public function newContract()
  {
    $nationalities = $this->model->select('nationality')->distinct()->findAll();
    $model = new \App\Models\BikesModel;
    $currentBikes = $model->getCurrentBikes();

    return view('Admin/Customers/newContract', [
      'nationalities' => $nationalities,
      'currentBikes' => $currentBikes,
    ]);
  }

  public function save()
  {
    $customer = new Customer;
    $customer->fill($this->request->getPost());

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
    $model = new \App\Models\BikesModel;
    $dragonBikes = $model->getDragonBikes();
    $dragonBikesPlateNumbers = [];

    foreach ($dragonBikes as $dragonBike) {

      $dragonBikesPlateNumbers[] = $dragonBike->plate_number;
    }

    if (in_array($customer->current_bike, $dragonBikesPlateNumbers)) {

      $customer->dragon_bikes = 1;
    }

    if ($this->model->insert($customer)) {
      // Get record of rental bike
      $bikesModel = new \App\Models\BikesModel;
      $bike = $bikesModel->getBikeByPlateNumber($customer->current_bike);

      // Get bike's current market value
      $bikeValuationsModel = new \App\Models\BikeValuationsModel;
      $valuationRecord = $bikeValuationsModel->getValueByModelAndYear($bike->model, $bike->year);

      // Format the value
      $value = number_format($valuationRecord->value * 1000, 0, '.', ',');

      // Pass all info from contract to use in activation email
      $this->sendActivationEmail($customer, $bike, $value);
      return redirect()->to(site_url('Admin/Home'));
    } else {

      return redirect()->back()->with('errors', $this->model->errors())->withInput();
    }
  }

  public function update()
  {
    $customer = new Customer;
    $customer->fill($this->request->getPost());

    // if ((bool) ($this->request->getPost('finish_date')) === true) {

    //   $customer->currently_renting = 0;
    // }

    if ($this->model->skipValidation(true)->save($customer)) {

      return redirect()->to(site_url('Admin/Customers/viewCurrentCustomers'));
    } else {

      return redirect()->back()->with('errors', $this->model->errors())->withInput();
    }
  }

  public function activate($token)
  {
    $model = new \App\Models\CustomersModel;

    $customer = $model->activateByToken($token);

    if ($customer) {

      $statusChangeModel = new \App\Models\BikeStatusChangeModel;
      $bikeStatusChange = new \App\Entities\BikeStatusChange;

      $bikeStatusChange->user = 'ADMIN';
      $bikeStatusChange->plate_number = $customer->current_bike;
      $bikeStatusChange->date_time = $customer->start_date;
      $bikeStatusChange->new_status = $customer->customer_name;
      $bikeStatusChange->customer_id = $customer->id;

      $statusChangeModel->save($bikeStatusChange);
    }

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

  public function viewInfo()
  {

    if (!$this->request->getPost('customer_name')) {
      return redirect()->back();
    }


    $customers = $this->model->getAllCustomers();
    dd('bananas');
    $customer = new Customer;
    $model = new \App\Models\BikeStatusChangeModel;
    $bikesModel = new \App\Models\BikesModel;
    $paymentsModel = new \App\Models\PaymentsModel;
    $found = 'false';

    foreach ($customers as $record) {

      if ($record->customer_name === $this->request->getPost('customer_name')) {

        $customer = $record;
        $found = 'true';
      }
    }

    if ($found === 'false') {

      return redirect()->back();
    }

    $currentStatus = $model->getCurrentStatus($customer->id);
    $currentBikes = $bikesModel->getCurrentBikes();
    $payments = $paymentsModel->getByContractNumber($customer->id);
    $monthsPaid = $paymentsModel->getTotalMonthsPaid($customer->id)->months_paid ?? 0;
    $startDate = new Time();
    $startDate = $startDate->createFromFormat('Y-m-d', $customer->start_date);
    $paidUpTo = $startDate->addMonths($monthsPaid)->toDateString();


    return view('Admin/Customers/viewInfo', [
      'customer' => $customer,
      'customers' => $customers,
      'currentStatus' => $currentStatus,
      'currentBikes' => $currentBikes,
      'payments' => $payments,
      'paidUpTo' => $paidUpTo,
    ]);
  }

  public function  viewCurrentCustomers()
  {
    $paymentsModel = new \App\Models\PaymentsModel;

    $customers = $this->model->getCurrentCustomers();

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

    return view('Admin/Customers/viewCurrentCustomers', ['customers' => $customers]);
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
}
