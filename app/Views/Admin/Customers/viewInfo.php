<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Customer Info<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php
if (!$customer) {
  return redirect()->back();
}
?>

<!-- This remains hidden until user presses 'Show Customer Details' button  -->

<?= form_open_multipart('Admin/Customers/update') ?>

<input type="hidden" name="id" value="<?= $customer->id ?>">

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="first_name">Name</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autocomplete="off" readonly class="input is-success first_name" id="first_name" name="customer_name" value="<?= old('customer_name', esc($customer->customer_name)) ?>">
      </p>
    </div>
  </div>
</div>

<div class="customer_info">

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="nationality">Nationality</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" readonly class="input is-success" id="nationality" name="nationality" value="<?= $customer->nationality ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="email_address">Email Address</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" readonly class="input is-success" id="email_address" name="email_address" value="<?= $customer->email_address ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="primary_contact_channel">Primary Contact Channel</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" readonly class="input is-success" id="primary_contact_channel" name="primary_contact_channel" value="<?= $customer->primary_contact_channel ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="phone_number">Phone Number</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" readonly class="input is-success" id="phone_number" name="phone_number" value="<?= $customer->phone_number ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="current_bike">Plate Number</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" readonly list="plate_number_list" class="input is-success" id="current_bike" name="current_bike" value="<?= $currentStatus->plate_number ?? ' '; ?>">
          <datalist id="plate_number_list">
            <?php foreach ($currentBikes as $currentBike) : ?>
              <option value="<?= $currentBike->plate_number ?>">
              <?php endforeach; ?>
          </datalist>
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="deposit_type">Deposit</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" readonly class="input is-success" id="deposit_type" name="deposit_type" value="<?= $customer->deposit_type ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="rent">Rental Amount</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" readonly class="input is-success" id="rent" name="rent" value="<?= $customer->rent ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="notes">Notes</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" readonly class="input is-success" id="notes" name="notes" value="<?= $customer->notes ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="building_name">Building Name</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" readonly class="input is-success" id="building_name" name="building_name" value="<?= $customer->building_name ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="building_number">Building Number</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" readonly class="input is-success" id="building_number" name="building_number" value="<?= $customer->building_number ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="street_name">Street Name</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" readonly class="input is-success" id="street_name" name="street_name" value="<?= $customer->street_name ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="ward">Ward</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" readonly class="input is-success" id="ward" name="ward" value="<?= $customer->ward ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="district">District</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" readonly class="input is-success" id="district" name="district" value="<?= $customer->district ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="start_date">Start Date</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" readonly type="date" class="input is-success" id="start_date" name="start_date" value="<?= $customer->start_date ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="finish_date">Finish Date</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" readonly type="date" class="input is-success" id="finish_date" name="finish_date" value="<?= $customer->finish_date ?? ''; ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal photoInput" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <!-- <label required class="label" for="passport">Passport Photo</label> -->
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <!-- <input autocomplete="off" type="file" class="input is-success" id="passport" name="passport"> -->
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal photoInput" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <!-- <label required class="label" for="TRC_or_visa">TRC or Visa</label> -->
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <!-- <input autocomplete="off" type="file" class="input is-success" id="TRC_or_visa" name="TRC_or_visa"> -->
        </p>
      </div>
    </div>
  </div>

  <div class="photoSection">
    <div class="photoBox" data-image="unloaded">
      <div class="photoCaption">Passport</div>
      <img class="photoImage" src="<?= site_url("Admin/Customers/displayCustomerPhoto/" . $customer->passport) ?>">
      <div class="deleteButton">Delete</div>
      <label class="selectPhoto" for="passport">Select Photo</label>
      <input autocomplete="off" type="file" class="photoInput" id="passport" name="passport">
    </div>

    <div class="photoBox" data-image="unloaded">
      <div class="photoCaption">TRC or Visa</div>
      <img class="photoImage" src="<?= site_url("Admin/Customers/displayCustomerPhoto/" . $customer->TRC_or_visa) ?>">
      <div class="deleteButton">Delete</div>
      <label class="selectPhoto" for="TRC_or_visa">Select Photo</label>
      <input autocomplete="off" type="file" class="photoInput" id="TRC_or_visa" name="TRC_or_visa">
    </div>

    <div class="photoBox" data-image="unloaded">
      <div class="photoCaption">License (Front)</div>
      <img class="photoImage" src="<?= site_url("Admin/Customers/displayCustomerPhoto/" . $customer->license_front) ?>">
      <div class="deleteButton">Delete</div>
      <label class="selectPhoto" for="license_front">Select Photo</label>
      <input autocomplete="off" type="file" class="photoInput" id="license_front" name="license_front">
    </div>

    <div class="photoBox" data-image="unloaded">
      <div class="photoCaption">License (Back)</div>
      <img class="photoImage" src="<?= site_url("Admin/Customers/displayCustomerPhoto/" . $customer->license_back) ?>">
      <div class="deleteButton">Delete</div>
      <label class="selectPhoto" for="license_back">Select Photo</label>
      <input autocomplete="off" type="file" class="photoInput" id="license_back" name="license_back">
    </div>

  </div>

  <div class="field is-horizontal">
    <div class="field-label">
      <!-- Left empty for spacing -->
    </div>
    <div class="field-body">
      <div class="field">
        <div class="control">
          <button class="button is-success is-large is-fullwidth" id="update">
            Update
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
</form>

<div class="edit_button">
  <div class="field is-horizontal">
    <div class="field-label">
      <!-- Left empty for spacing -->
    </div>
    <div class="field-body">
      <div class="field">
        <div class="control">
          <button class="button is-link is-large is-fullwidth" id="edit">
            Edit
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label">
    <!-- Left empty for spacing -->
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <button class="button is-link is-large is-fullwidth" id="showCustomerDetails">
          Show Customer Details
        </button>
      </div>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label">
    <!-- Left empty for spacing -->
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <button class="button is-success is-large is-fullwidth" id="show_payments">
          Get Payment History
      </div>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label">
    <!-- Left empty for spacing -->
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <a href="<?= site_url('Admin/Home') ?>">
          <button class="button is-warning is-large is-fullwidth" id="show_payments">
            Main Menu
          </button>
        </a>
      </div>
    </div>
  </div>
</div>

<!-- This stays hidden unless user presses 'Get Payment History' button  -->
<div class="payment_history">

  <table class="table block is-fullwidth">
    <thead>
      <tr>
        <th>Contract</th>
        <th>Name</th>
        <th>Bike</th>
        <th>Rent</th>
        <th>Start Date</th>
        <th>Paid Up To</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td><?= $customer->id ?></td>
        <td><?= $customer->customer_name ?></td>
        <td><?= $currentStatus->plate_number ?? ' '; ?></td>
        <td><?= $customer->rent ?></td>
        <td><?= $customer->start_date ?></td>
        <td><?= $paidUpTo ?></td>
      </tr>
    </tbody>
  </table>

  <table class="table is-fullwidth">
    <thead>
      <tr>
        <th>Amount</th>
        <th>Months Paid</th>
        <th>Date</th>
        <th>Payment Method</th>
        <th></th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($payments as $payment) : ?>
        <tr>
          <td><?= $payment->amount ?></td>
          <td><?= $payment->months_paid ?></td>
          <td><?= $payment->payment_date ?></td>
          <td><?= $payment->payment_method ?></td>
          <td><a href="<?= site_url('Admin/Payments/update/') . $payment->id ?>"><button class="button is-link">Edit</button></a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</div>

<script src="<?= site_url('js/Customers/viewInfo.js'); ?>"></script>

<?= $this->endSection() ?>