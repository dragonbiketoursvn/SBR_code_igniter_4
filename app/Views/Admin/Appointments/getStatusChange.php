<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Status Change<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?= form_open('Admin/Appointments/saveStatusChange', 'id="status_change"') ?>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="bike_out">Khách <span style="color: tomato;">NHẬN</span> Xe Biển Số Bao Nhiêu?</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input list="current_bikes" class="input is-success" id="bike_out" name="bike_out">
        <datalist id="current_bikes">
          <?php foreach($currentBikes as $currentBike): ?>
            <option value="<?= $currentBike->plate_number ?>">
          <?php endforeach; ?>
        </datalist>
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="bike_in">Khách <span style="color: tomato;">TRẢ LẠI</span> Xe Biển Số Bao Nhiêu?</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input list="current_bikes" class="input is-success" id="bike_in" name="bike_in">
        <datalist id="current_bikes">
          <?php foreach($currentBikes as $currentBike): ?>
            <option value="<?= $currentBike->plate_number ?>">
          <?php endforeach; ?>
        </datalist>
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
      <button type="submit" form="status_change" class="button is-success" style="width: 50% !important;">Dúng rồi. Nhập đi!</button>
      <button class="button is-danger close-toggle" style="width: 50% !important;">Tôi cần chỉnh lại</button>
    </footer>
  </div>
</div>



<script>
const modal = document.querySelector('.modal');
const buttonOpenModal = document.querySelector('.toggle');
const buttonCloseModal = document.querySelector('.close-toggle');

const stringSegment1 = "Khách <b>trả lại</b> xe biển số <b>";
const stringSegment2 = "</b><br>";
const stringSegment3 = "Khách <b>nhận</b> xe biển số <b>";
const stringSegment4 = "</b><br> Thông tin này có đúng ko?";

const toggle = function() {

  let bike_in = document.querySelector('input[name="bike_in"]');
  let bike_out = document.querySelector('input[name="bike_out"]');

  let message = '';

  if(bike_in.value != ''){

    message += stringSegment1 + bike_in.value + stringSegment2;

  } else {

    message += 'Khách ko trả lại xe.<br>'

  }

  if(bike_out.value != ''){

    message += stringSegment3 + bike_out.value;

  } else {

    message += 'Khách ko nhận xe.'

  }

  message += stringSegment4;



  /*
  let messageOne = `${stringSegment1}${bike_in.value}`;
  let messageTwo = `${stringSegment2}${months_paid.value}`;
  */

  document.querySelector('.modal-card-body').innerHTML = message;

  modal.classList.add('is-active');

 };

 const closeToggle = function() {

  modal.classList.remove('is-active');

 };

buttonOpenModal.addEventListener('click', toggle);
buttonCloseModal.addEventListener('click', closeToggle);
</script>


<?= $this->endSection() ?>
