<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Status Change<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php if(session()->has('errors')): ?>
  <ul>
    <?php foreach(session('errors') as $error): ?>
      <li>
        <?= $error ?>
      <li>
    <?php endforeach; ?>
  <ul>
<?php endif; ?>




<?= form_open('Admin/Customers/save', 'id="rental_contract"') ?>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="first_name">First Name</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success first_name" id="first_name" name="first_name">
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
        <input class="input is-success surname" id="surname" name="surname">
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
        <input list="parts_list" class="input is-success" id="nationality" name="nationality">
        <datalist id="parts_list">
          <?php foreach($nationalities as $nationality): ?>
            <option value="<?= $nationality->nationality ?>">
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
        <input class="input is-success" id="email_address" name="email_address">
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
        <input class="input is-success" id="phone_number" name="phone_number">
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
        <input list="plate_number_list" class="input is-success" id="current_bike" name="current_bike">
        <datalist id="plate_number_list">
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
    <label class="label" for="deposit_type">Deposit</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" id="deposit_type" name="deposit_type">
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
        <input class="input is-success" id="rent" name="rent">
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
        <input class="input is-success" id="notes" name="notes">
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
        <input class="input is-success" id="building_name" name="building_name">
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
        <input class="input is-success" id="building_number" name="building_number">
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
        <input class="input is-success" id="street_name" name="street_name">
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
        <input class="input is-success" id="ward" name="ward">
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
        <input class="input is-success" id="district" name="district">
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

    </section>
    <footer class="modal-card-foot">
      <button type="submit" form="rental_contract" class="button is-success" style="width: 50% !important;">Dúng rồi. Nhập đi!</button>
      <button class="button is-danger close-toggle" style="width: 50% !important;">Tôi cần chỉnh lại</button>
    </footer>
  </div>
</div>

<script>

const modal = document.querySelector('.modal');
const buttonOpenModal = document.querySelector('.toggle');
const buttonCloseModal = document.querySelector('.close-toggle');

const form = document.querySelector('#rental_contract');
const first_name = document.querySelector('.first_name');
const surname = document.querySelector('.surname');
let full_name = document.querySelector('.full_name');

form.addEventListener('submit', function(e) {

  first_name.value = first_name.value.toLowerCase();
  let firstArray = [...first_name.value];
  firstArray[0] = firstArray[0].toUpperCase();
  first_name.value = firstArray.join('');

  surname.value = surname.value.toLowerCase();
  let secondArray = [...surname.value];
  secondArray[0] = secondArray[0].toUpperCase();
  surname.value = secondArray.join('');

  full_name.value =  first_name.value + ' ' + surname.value;

})

const toggle = function() {

  //let total = document.querySelector('input[name="total_cost"]');
  //let labor = document.querySelector('input[name="labor_cost"]');

  //let message = `Giá tổng cộng là ${total.value} và tiền công là ${labor.value}, đúng ko?`;

  //document.querySelector('.modal-card-body').innerHTML = message;

  modal.classList.add('is-active');

 };

 const closeToggle = function() {

  modal.classList.remove('is-active');

 };

buttonOpenModal.addEventListener('click', toggle);
buttonCloseModal.addEventListener('click', closeToggle);


</script>


<?= $this->endSection() ?>
