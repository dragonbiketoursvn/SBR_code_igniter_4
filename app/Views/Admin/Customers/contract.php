<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Tạo Cuộc Hẹn Mới<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?= form_open('Admin/Customers/saveNew') ?>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="name">Full Name</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autocomplete="off" required class="input is-success" id="name" name="name" placeholder="Full Name">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="nationalities">Nationality</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autocomplete="off" required list="nationalities" class="input is-success" id="nationalities" name="nationalities" placeholder="Nationality">
        <datalist id="nationalities">
          <?php foreach($nationalities as $nationality): ?>
            <option value="<?= $nationality['nationality'] ?>">
          <?php endforeach; ?>
        </datalist>
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
        <input autocomplete="off" type="email" required class="input is-success" id="email_address" name="email_address" placeholder="Email Address">
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
        <input autocomplete="off" type="tel" required class="input is-success" id="phone_number" name="phone_number" placeholder="Phone Number">
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
        <input autocomplete="off" list="building_names" class="input is-success" id="building_name" name="building_name" placeholder="Building Name">
        <datalist id="building_names">
          <?php foreach($buildingNames as $buildingName): ?>
            <option value="<?= $buildingName['building_name'] ?>">
          <?php endforeach; ?>
        </datalist>
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
        <input autocomplete="off" class="input is-success" id="building_number" name="building_number" placeholder="Bulding Number">
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
        <input autocomplete="off" required list="street_names" class="input is-success" id="street_name" name="street_name" placeholder="Street Name">
        <datalist id="street_names">
          <?php foreach($streetNames as $streetName): ?>
            <option value="<?= $streetName['street_name'] ?>">
          <?php endforeach; ?>
        </datalist>
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
        <input autocomplete="off" required list="districts" class="input is-success" id="district" name="district" placeholder="District">
        <datalist id="districts">
          <?php foreach($districts as $district): ?>
            <option value="<?= $district['district'] ?>">
          <?php endforeach; ?>
        </datalist>
      </p>
    </div>
  </div>
</div>

<input type="hidden" name="start_date" value="<?= date('Y-m-d H:i:s', time()) ?>">


<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="plate_number">Plate Number</label>
  </div>                
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autocomplete="off" required list="plate_numbers" class="input is-success" id="plate_number" name="plate_number" placeholder="Plate Number">
        <datalist id="plate_numbers">
          <?php foreach($currentBikes as $currentBike): ?>
            <option value="<?= $currentBike->plate_number ?>">
          <?php endforeach; ?>
        </datalist>
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="rent">Rent</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autocomplete="off" class="input is-success" id="rent" name="rent" placeholder="Monthly Rent">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="rent">Deposit</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autocomplete="off" class="input is-success" id="deposit_type" name="deposit_type" placeholder="Deposit">
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
        <button class="button is-available is-large is-fullwidth toggle">
          Submit
        </button>
      </div>
    </div>
  </div>
</div>

</form>

<?= $this->endSection() ?>
