<!-- <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
      button {border-radius: 10px; background-color: turquoise;}
      .sunday {border-radius: 10px; background-color: gray; color: gray;}
      .alreadyBooked {border-radius: 10px; background-color: green; color: yellow; border: 2px solid red}
      table {border: 0px;}
    </style>

    <title>Choose Location</title>

</head>

<body>-->




<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Location Selector<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?= form_open(site_url('/appointments/saveLocation/' . $token)); ?>

<div class="block">
  <section class="hero is-link">
    <div class="hero-body has-text-centered">
      <p class="title">
       And Where We Should Meet You!
      </p>
    </div>
  </section>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="building_name">Building Name</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" type="text" id="building_name" name="building_name" value="<?= esc($appointment->building_name) ?>">
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
        <input class="input is-success" type="text" id="number" name="number" value="<?= esc($appointment->number) ?>">
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
        <input class="input is-success" type="text" id="street_name" name="street_name" value="<?= esc($appointment->street_name) ?>">
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
        <input class="input is-success" type="text" id="ward" name="ward" value="<?= esc($appointment->ward) ?>">
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
        <input class="input is-success" type="text" id="district" name="district" value="<?= esc($appointment->district) ?>">
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
        <button class="button is-available is-fullwidth">
          Click to Submit
        </button>
      </div>
    </div>
  </div>
</div>

</form>

<?= $this->endSection() ?>
