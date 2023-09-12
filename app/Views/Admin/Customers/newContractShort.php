<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Short-Term Contract<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php if (session()->has('errors')) : ?>
  <ul>
    <?php foreach (session('errors') as $error) : ?>
      <li>
        <h1 style="color:red;"><?= $error ?></h1>
      <li>
      <?php endforeach; ?>
      <ul>
      <?php endif; ?>


      <?= form_open_multipart('Admin/Customers/save', 'id="rental_contract"') ?>

      <input type="hidden" id="usd_to_vnd" value=<?= $USD_TO_VND ?>>
      <input type="hidden" id="vnd_to_usd" value=<?= $VND_TO_USD ?>>

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label" for="start_date">Start Date</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input required autocomplete="off" class="input is-success" type="date" name="start_date" id="start_date" value="<?= date('Y-m-d') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label" for="start_date">Finish Date</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input required autocomplete="off" class="input is-success" type="date" name="finish_date" id="finish_date">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label" for="start_city">Start City</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input required autocomplete="off" class="input is-success" name="start_city" id="start_city" value="<?= old('start_city') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label" for="start_city">Finish City</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input required autocomplete="off" class="input is-success" name="finish_city" id="finish_city" value="<?= old('finish_city') ?>">
            </p>
          </div>
        </div>
      </div>

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
      <input type="hidden" name="short_term" value=1>

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
          <label class="label" for="odometer_start">Odometer Start</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autocomplete="off" class="input is-success" id="odometer_start" name="odometer_start" value="<?= old('odometer_start') ?>">
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
          <label type="number" min=500 max=5000 step=100 class="label" for="rent_usd">Rental Amount (USD)</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input required autocomplete="off" class="input is-success" id="rent_usd" name="rent_usd" value="<?= old('rent_usd') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label type="number" min=500 step=100 class="label" for="rent">Rental Amount (x1000 VND)</label>
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
          <label class="label" for="number_full_helmets"># Full Helmets</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autocomplete="off" type="tel" class="input is-success" id="number_full_helmets" name="number_full_helmets" value="<?= old('number_full_helmets') ?>">
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
              <input autocomplete="off" type="tel" class="input is-success" id="replacement_cost_full_helmet" name="replacement_cost_full_helmet" value="<?= old('replacement_cost_full_helmet') ?>">
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
              <input autocomplete="off" type="tel" class="input is-success" id="number_three_quarter_helmets" name="number_three_quarter_helmets" value="<?= old('number_three_quarter_helmets') ?>">
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
              <input autocomplete="off" type="tel" class="input is-success" id="replacement_cost_three_quarter_helmet" name="replacement_cost_three_quarter_helmet" value="<?= old('replacement_cost_three_quarter_helmet') ?>">
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
              <input autocomplete="off" type="tel" class="input is-success" id="givi_topcase" name="givi_topcase" value="<?= old('givi_topcase') ?>">
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
              <input autocomplete="off" type="tel" class="input is-success" id="givi_topcase_replacement_cost" name="givi_topcase_replacement_cost" value="<?= old('givi_topcase_replacement_cost') ?>">
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
              <input autocomplete="off" type="tel" class="input is-success" id="givi_pannier_quantity" name="givi_pannier_quantity" value="<?= old('givi_pannier_quantity') ?>">
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
              <input autocomplete="off" type="tel" class="input is-success" id="givi_pannier_replacement_cost" name="givi_pannier_replacement_cost" value="<?= old('givi_pannier_replacement_cost') ?>">
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
              <input autocomplete="off" type="tel" class="input is-success" id="madfox_saddlebags" name="madfox_saddlebags" value="<?= old('madfox_saddlebags') ?>">
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
              <input autocomplete="off" type="tel" class="input is-success" id="madfox_saddlebags_replacement_cost" name="madfox_saddlebags_replacement_cost" value="<?= old('madfox_saddlebags_replacement_cost') ?>">
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
              <input autocomplete="off" type="tel" class="input is-success" id="inner_tubes_quantity" name="inner_tubes_quantity" value="<?= old('inner_tubes_quantity') ?>">
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
              <input autocomplete="off" type="tel" class="input is-success" id="inner_tubes_replacement_cost" name="inner_tubes_replacement_cost" value="<?= old('inner_tubes_replacement_cost') ?>">
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
              <input autocomplete="off" type="tel" class="input is-success" id="damage_insurance_amount" name="damage_insurance_amount" value="<?= old('damage_insurance_amount') ?>">
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
              <input autocomplete="off" class="input is-success" id="additional_items_services" name="additional_items_services" value="<?= old('additional_items_services') ?>">
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
              <input autocomplete="off" type="tel" class="input is-success" id="additional_items_cost" name="additional_items_cost" value="<?= old('additional_items_cost') ?>">
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

      <script src="<?= site_url('js/Customers/currencyConversion5.js') ?>"></script>

      <?= $this->endSection() ?>