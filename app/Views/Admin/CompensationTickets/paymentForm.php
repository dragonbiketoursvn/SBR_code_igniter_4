<?= $this->extend("layouts/default") ?>


<?= $this->section('title') ?>Compensation Payment Form<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="block">
  <section class="hero is-success">
    <div class="hero-body has-text-centered" style="margin-bottom: 0px;">
      <p class="title">
        Compensation Payment Form
      </p>
    </div>
  </section>
</div>

<?php if (session()->has('errors')) : ?>
  <div class="block">
    <ul>
      <?php foreach (session('errors') as $error) : ?>
        <li style="color: tomato;"><b><?= $error ?></b></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?= form_open('Admin/Payments/saveCompensationPayment', 'id="payment_form" class="random_class"') ?>

<input type="hidden" name="compensation_ticket_id" value="<?= esc($appointment->compensationTicket->id) ?>">

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="customer_name">Customer Name</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input required readonly class="input is-success" type="text" id="customer_name" value="<?= esc($appointment->customer_name) ?>">
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="bike">Bike</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input required readonly class="input is-success" type="text" id="bike"
        value="<?= esc($appointment->compensationTicket->plate_number) ?>">
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="grounds">Grounds For Compensation</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input required readonly class="input is-success" type="text" id="grounds"
        value="<?= esc($appointment->compensationTicket->stolen_destroyed_damaged) ?>">
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="grounds">Total Compensation Amount</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input required readonly class="input is-success" type="text" id="grounds"
        value="<?= esc($appointment->compensationTicket->cost_incurred) ?>">
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="grounds">Amount Remaining</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input required readonly class="input is-success" type="text" id="grounds"
        value="<?= $appointment->compensationTicket->cost_incurred - $appointment->paidToDate ?>">
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="paid_to_date">Paid to Date (x1000 đồng)</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input readonly class="input is-success" type="text" id="paid_to_date" value="<?= $appointment->paidToDate ?>">
    </div>
  </div>
</div>


<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="compensation_payment">Amount Paid (x1000 đồng)</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input autofocus required autocomplete="off" class="input is-success" type="text" id="compensation_payment" name="amount" value="<?= old('amount') ?>">
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="payment_date">Payment Date</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input required autocomplete="off" class="input is-success" type="date" id="payment_date" name="date" value="<?= date('Y-m-d') ?>">
      </p>
    </div>
  </div>
</div>

<?php if (session()->get('user_level') == 'super') : ?>

  <div class="field">
    <div class="control">
      <label class="radio">
        <input type="radio" name="payment_method" value="cash" checked>
        Cash
      </label>
      <label class="radio">
        <input type="radio" name="payment_method" value="bank_transfer">
        Bank Transfer
      </label>
      <label class="radio">
        <input type="radio" name="payment_method" value="paypal">
        PayPal
      </label>
    </div>
  </div>

<?php endif; ?>

<div class="field is-horizontal">
  <div class="field-label">
    <!-- Left empty for spacing -->
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <button class="button is-available is-large is-fullwidth toggle">
          Submit
        </button>
      </div>
    </div>
  </div>
</div>

</form>

<?= $this->endSection() ?>