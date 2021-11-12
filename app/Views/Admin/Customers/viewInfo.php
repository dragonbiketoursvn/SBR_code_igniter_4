<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Customer Info<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php if (!$customer) {
  return redirect()->back();
}
?>

<?= form_open('Admin/Customers/update') ?>

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

<div class="customer_info" style="display: none;">

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



<div class="edit_button" style="display: none;">
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
        <button class="button is-link is-large is-fullwidth" id="display_info">
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

<div class="payment_history" style="display: none;">

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

<script>
  const edit = document.querySelector('.edit_button');
  const submit = document.querySelector('#update');
  const inputs = document.querySelectorAll('input');
  const displayInfo = document.querySelector('#display_info');
  const customerInfo = document.querySelector('.customer_info');
  const showPayments = document.querySelector('#show_payments');
  const paymentHistory = document.querySelector('.payment_history');

  window.onload = function() {

    submit.style.display = 'none';

  }

  edit.addEventListener('click', function(e) {

    inputs.forEach(function(input) {

      input.removeAttribute('readonly');

    });

    edit.style.display = 'none';
    submit.style.display = 'block';

  });

  displayInfo.addEventListener('click', function(e) {

    edit.style.display = 'block';
    customerInfo.style.display = 'block';
    e.target.style.display = 'none';

  });

  showPayments.addEventListener('click', function(e) {

    paymentHistory.style.display = 'block';
    e.target.style.display = 'none';

  });
</script>

<?= $this->endSection() ?>