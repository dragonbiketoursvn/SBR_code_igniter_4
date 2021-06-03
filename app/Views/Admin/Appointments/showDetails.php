<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Location Selector<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php if($appointment): ?>

<div class="block">
  <section class="hero is-success">
    <div class="hero-body has-text-centered" style="margin-bottom: 0px;">
      <p class="title">
       Appointment Details
      </p>
    </div>
  </section>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="customer_name">Customer Name</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input class="input is-success" type="text" id="customer_name" name="customer_name" value="<?= esc($appointment->customer_name) ?>" disabled>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="building_name">Building Name</label>
  </div>
  <div class="field-body">
    <div class="field">
        <input class="input is-success" type="text" id="building_name" name="building_name" value="<?= esc($appointment->building_name) ?>" disabled>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="number">House Number</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" type="text" id="number" name="number" value="<?= esc($appointment->number) ?>" disabled>
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="street_name">Street Name</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" type="text" id="street_name" name="street_name" value="<?= esc($appointment->street_name) ?>" disabled>
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="ward">Ward</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" type="text" id="ward" name="ward" value="<?= esc($appointment->ward) ?>" disabled>
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="district">District</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" type="text" id="district" name="district" value="<?= esc($appointment->district) ?>" disabled>
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="district">Appointment Purpose</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" type="text" id="district" name="district" value="<?php

        $string = '';

        if($appointment->pay_rent == 1) {
          $string .= 'pay rent, ';
        }

        if($appointment->full_service == 1) {
          $string .= 'full service ';
        }

        if($appointment->small_service == 1) {
          $string .= 'small service ';
        }

        echo $string;

        ?>" disabled>
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="time">Appointment Date and Time</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" type="text" id="time" name="time" value="<?= esc($appointment->appointment_time) ?>" disabled>
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
        <a href="<?= //form_open("Admin/Appointments/startInteraction/{$appointment->id}")
                      site_url('Admin/Appointments/paymentCheck') ?>">
          <button class="button is-available is-large is-fullwidth">
            Bấm lúc gặp khách
          </button>
        </a>
      </div>
    </div>
  </div>
</div>

<?php else: ?>

  Ko có cuộc hẹn lúc này.

<?php endif; ?>

<?= $this->endSection() ?>
