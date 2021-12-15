<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Status Change<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php if (session()->has('errors')) : ?>
  <ul>
    <?php foreach (session('errors') as $error) : ?>
      <li>
        <?= $error ?>
      <li>
      <?php endforeach; ?>
      <ul>
      <?php endif; ?>


      <?= form_open_multipart('Admin/Customers/save', 'id="rental_contract"') ?>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label class="label" for="first_name">First Name</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autofocus required autocomplete="off" class="input is-success first_name" id="first_name" name="first_name" value="<?= old('first_name') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label class="label" for="surname">Surname</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input required autocomplete="off" class="input is-success surname" id="surname" name="surname" value="<?= old('surname') ?>">
            </p>
          </div>
        </div>
      </div>

      <input type="hidden" class="full_name" name="customer_name" value>
      <input type="hidden" name="start_date" value="<?= date('Y-m-d') ?>">

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label class="label" for="nationality">Nationality</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input required autocomplete="off" list="nationalities_list" class="input is-success" id="nationality" name="nationality" value="<?= old('nationality') ?>">
              <datalist id="nationalities_list">
                <?php foreach ($nationalities as $nationality) : ?>
                  <option value="<?= $nationality->nationality ?>">
                  <?php endforeach; ?>
              </datalist>
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label type="email" class="label" for="email_address">Email Address</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input required autocomplete="off" class="input is-success" id="email_address" name="email_address" value="<?= old('email_address') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label type="tel" class="label" for="phone_number">Phone Number</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input required autocomplete="off" class="input is-success" id="phone_number" name="phone_number" value="<?= old('phone_number') ?>">
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
              <input required autocomplete="off" list="plate_number_list" class="input is-success" id="current_bike" name="current_bike" value="<?= old('current_bike') ?>">
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
              <input autocomplete="off" class="input is-success" id="deposit_type" name="deposit_type" value="<?= old('deposit_type') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label type="number" min=500 max=5000 step=100 class="label" for="rent">Rental Amount (x1000 dong)</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input required autocomplete="off" class="input is-success" id="rent" name="rent" value="<?= old('rent') ?>">
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
              <input autocomplete="off" class="input is-success" id="notes" name="notes" value="<?= old('notes') ?>">
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
              <input autocomplete="off" class="input is-success" id="building_name" name="building_name" value="<?= old('building_name') ?>">
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
              <input autocomplete="off" class="input is-success" id="building_number" name="building_number" value="<?= old('building_number') ?>">
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
              <input autocomplete="off" class="input is-success" id="street_name" name="street_name" value="<?= old('street_name') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label required class="label" for="ward">Ward</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autocomplete="off" class="input is-success" id="ward" name="ward" value="<?= old('ward') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label required class="label" for="district">District</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autocomplete="off" class="input is-success" id="district" name="district" value="<?= old('district') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label required class="label" for="passport">Passport Photo</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autocomplete="off" type="file" class="input is-success" id="passport" name="passport">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label required class="label" for="TRC_or_visa">TRC or Visa</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autocomplete="off" type="file" class="input is-success" id="TRC_or_visa" name="TRC_or_visa">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label required class="label" for="license_front">License (Front)</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autocomplete="off" type="file" class="input is-success" id="license_front" name="license_front">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label required class="label" for="license_back">License (Back)</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autocomplete="off" type="file" class="input is-success" id="license_back" name="license_back">
            </p>
          </div>
        </div>
      </div>

      </form>

      <div class="field is-horizontal">
        <div class="field-label">
          <!-- Left empty for spacing -->
        </div>
        <div class="field-body">
          <div class="field">
            <div class="control">
              <button class="button is-available is-large is-fullwidth toggle">
                Nhập Thông Tin
              </button>
            </div>
          </div>
        </div>
      </div>




      <div class="modal">
        <div class="modal-background"></div>
        <div class="modal-card">

          <section class="modal-card-body" style="font-size: 15px !important; text-align: center !important; padding: 2px !important;">
            <p>Tất cả các thông tin này có đúng ko?</p>
          </section>
          <footer class="modal-card-foot">
            <button type="submit" form="rental_contract" class="button is-success" style="width: 50% !important;">Dúng rồi. Nhập đi!</button>
            <button class="button is-danger close-toggle" style="width: 50% !important;">Tôi cần chỉnh lại</button>
          </footer>
        </div>
      </div>

      <script src="<?= site_url('js/Customers/newContract.js') ?>"></script>


      <?= $this->endSection() ?>