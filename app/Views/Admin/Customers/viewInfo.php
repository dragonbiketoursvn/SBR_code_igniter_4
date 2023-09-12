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
<input type="hidden" name="short_term" value="<?= $customer->short_term ?>">

<?php if ($customer->short_term) : ?>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="currently_renting" style="color:red; font-weight:bold;">Currently Renting</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" readonly class="input is-success" id="currently_renting" name="currently_renting" value="<?= $customer->currently_renting ?>">
        </p>
      </div>
    </div>
  </div>
<?php endif; ?>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="first_name">Name</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autocomplete="off" readonly class="input is-success first_name" id="first_name" name="customer_name" value="<?= $customer->customer_name ?>">
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

  <?php if (!$customer->short_term) : ?>

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

  <?php endif; ?>

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

  <?php if ($customer->short_term) : ?>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="odometer_start">Odometer Start</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" class="input is-success" id="odometer_start" name="odometer_start" value="<?= $customer->odometer_start ?>">
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="odometer_finish">Odometer Finish</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" class="input is-success" id="odometer_finish" name="odometer_finish" value="<?= $customer->odometer_finish ?>">
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="number_full_helmets"># Full Helmets</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" type="tel" class="input is-success" id="number_full_helmets" name="number_full_helmets" value="<?= $customer->number_full_helmets ?>">
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="replacement_cost_full_helmet">Replacement Cost Per Item</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" type="tel" class="input is-success" id="replacement_cost_full_helmet" name="replacement_cost_full_helmet" value="<?= $customer->replacement_cost_full_helmet ?>">
          </p>
        </div>
      </div>
    </div>


    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="number_three_quarter_helmets"># 3/4 Helmets</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" type="tel" class="input is-success" id="number_three_quarter_helmets" name="number_three_quarter_helmets" value="<?= $customer->number_three_quarter_helmets ?>">
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="replacement_cost_three_quarter_helmet">Replacement Cost Per Item</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" type="tel" class="input is-success" id="replacement_cost_three_quarter_helmet" name="replacement_cost_three_quarter_helmet" value="<?= $customer->replacement_cost_three_quarter_helmet ?>">
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="givi_topcase"># Givi Topcases</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" type="tel" class="input is-success" id="givi_topcase" name="givi_topcase" value="<?= $customer->givi_topcase ?>">
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="givi_topcase_replacement_cost">Replacement Cost Per Item</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" type="tel" class="input is-success" id="givi_topcase_replacement_cost" name="givi_topcase_replacement_cost" value="<?= $customer->givi_topcase_replacement_cost ?>">
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="givi_pannier_quantity"># Givi Panniers</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" type="tel" class="input is-success" id="givi_pannier_quantity" name="givi_pannier_quantity" value="<?= $customer->givi_pannier_quantity ?>">
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="givi_pannier_replacement_cost">Replacement Cost Per Item</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" type="tel" class="input is-success" id="givi_pannier_replacement_cost" name="givi_pannier_replacement_cost" value="<?= $customer->givi_pannier_replacement_cost ?>">
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="madfox_saddlebags"># MadFox Saddlebags</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" type="tel" class="input is-success" id="madfox_saddlebags" name="madfox_saddlebags" value="<?= $customer->madfox_saddlebags ?>">
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="madfox_saddlebags_replacement_cost">Replacement Cost Per Item</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" type="tel" class="input is-success" id="madfox_saddlebags_replacement_cost" name="madfox_saddlebags_replacement_cost" value="<?= $customer->madfox_saddlebags_replacement_cost ?>">
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="inner_tubes_quantity"># Inner Tubes</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" type="tel" class="input is-success" id="inner_tubes_quantity" name="inner_tubes_quantity" value="<?= $customer->inner_tubes_quantity ?>">
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="inner_tubes_replacement_cost">Replacement Cost Per Item</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" type="tel" class="input is-success" id="inner_tubes_replacement_cost" name="inner_tubes_replacement_cost" value="<?= $customer->inner_tubes_replacement_cost ?>">
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="damage_insurance_amount">Damage Insurance Amount</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" type="tel" class="input is-success" id="damage_insurance_amount" name="damage_insurance_amount" value="<?= $customer->damage_insurance_amount ?>">
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="additional_items_services">Additional Items/Services</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" class="input is-success" id="additional_items_services" name="additional_items_services" value="<?= $customer->additional_items_services ?>">
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="service_complete">Service Complete?</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" class="input is-success" id="service_complete" name="service_complete" value="<?= $customer->service_complete ?>">
          </p>
        </div>
      </div>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
      <div class="field-label is-normal">
        <label class="label" for="additional_items_cost">Cost</label>
      </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autocomplete="off" type="tel" class="input is-success" id="additional_items_cost" name="additional_items_cost" value="<?= $customer->additional_items_cost ?>">
          </p>
        </div>
      </div>
    </div>


  <?php endif; ?>

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
      <img class="photoImage" src="<?= $customer->passport ? site_url("Admin/Customers/displayCustomerPhoto/" . $customer->passport) : '' ?>">
      <div class="deleteButton">Delete</div>
      <label class="selectPhoto" for="passport">Select Photo</label>
      <input autocomplete="off" type="file" class="photoInput" id="passport" name="passport">
    </div>

    <div class="photoBox" data-image="unloaded">
      <div class="photoCaption">TRC or Visa</div>
      <img class="photoImage" src="<?= $customer->TRC_or_visa ? site_url("Admin/Customers/displayCustomerPhoto/" . $customer->TRC_or_visa) : '' ?>">
      <div class="deleteButton">Delete</div>
      <label class="selectPhoto" for="TRC_or_visa">Select Photo</label>
      <input autocomplete="off" type="file" class="photoInput" id="TRC_or_visa" name="TRC_or_visa">
    </div>

    <div class="photoBox" data-image="unloaded">
      <div class="photoCaption">License (Front)</div>
      <img class="photoImage" src="<?= $customer->license_front ? site_url("Admin/Customers/displayCustomerPhoto/" . $customer->license_front) : '' ?>">
      <div class="deleteButton">Delete</div>
      <label class="selectPhoto" for="license_front">Select Photo</label>
      <input autocomplete="off" type="file" class="photoInput" id="license_front" name="license_front">
    </div>

    <div class="photoBox" data-image="unloaded">
      <div class="photoCaption">License (Back)</div>
      <img class="photoImage" src="<?= $customer->license_back ? site_url("Admin/Customers/displayCustomerPhoto/" . $customer->license_back) : '' ?>">
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