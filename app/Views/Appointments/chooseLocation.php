<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Location Selector<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="block">
  <section class="hero is-link">
    <div class="hero-body has-text-centered" style="margin-bottom: 0px;">
      <p class="title">
       And Where Should We Meet?
      </p>
    </div>
  </section>
</div>

<?= form_open(site_url('/appointments/saveLocation/' . $token)); ?>
<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="building_name">Building Name</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" type="text" id="building_name" name="building_name" value="<?= esc($appointment->building_name) ?>" autofocus>
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
        <button class="button is-available is-large is-fullwidth">
          Click to Submit
        </button>
      </div>
    </div>
  </div>
</div>

</form>

<?= $this->endSection() ?>
