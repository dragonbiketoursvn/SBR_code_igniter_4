<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Appointment Details<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="block">
  <section class="hero is-link">
    <div class="hero-body has-text-centered">
      <p class="title">
        Your Currently Scheduled Appointment:
      </p>
    </div>
  </section>
</div>

<div style="padding-right: 100px;">
  <div class="field is-horizontal">
    <div class="field-label is-normal">
      <label class="label" for="appointment_time">Appointment Time</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input class="input is-success" type="text" id="appointment_time" name="building_name" value="<?php if ($appointment->appointment_time === '0000-00-00 00:00:00') {

                                                                                                          echo 'No Time Currently Scheduled';
                                                                                                        } else {

                                                                                                          $datetime = new \DateTime($appointment->appointment_time);
                                                                                                          echo $datetime->format('D, j F - G:iA');
                                                                                                        }

                                                                                                        ?>" disabled>
      </div>
    </div>
  </div>

  <div class="field is-horizontal">
    <div class="field-label is-normal">
      <label class="label" for="building_name">Building Name</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
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
    <div class="field-label">
      <!-- Left empty for spacing -->
    </div>
    <div class="field-body">
      <div class="field">
        <div class="control">
          <?= form_open(site_url('/appointments/delete/' . $token)) ?>
          <input type="hidden" name="appointment_start" value=''>
          <button class="button is-danger is-large is-fullwidth">
            <b>Cancel</b>
          </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>