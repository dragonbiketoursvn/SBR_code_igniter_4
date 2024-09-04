<?= $this->extend("layouts/default") ?>


<?= $this->section('title') ?>Update Report<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="block">
  <section class="hero is-danger">
    <div class="hero-body has-text-centered" style="margin-bottom: 0px;">
      <p class="title">
        Update Bike Status Change Report
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

<?= form_open('Admin/BikeStatusChanges/saveUpdate', 'id="incident_form" class="random_class"') ?>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="date_time">Date-Time</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" type="datetime-local" id="date_time" name="date_time" value="<?= esc($bikeStatusChange->date_time) ?>">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="plate_number">Plate Number</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input disabled class="input is-success" type="text" id="plate_number"
        name="plate_number" value="<?= esc($bikeStatusChange->plate_number) ?>">
    </div>
  </div>
</div>


<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="new_status">New Status</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input disabled class="input is-success" id="new_status" name="new_status"
          value="<?= esc($bikeStatusChange->new_status) ?>">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="temporary">Temporary</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input type="hidden" class="input is-success" name="temporary" value="0">
        <input type="checkbox" id="temporary"
          name="temporary" value="1" <?= esc($bikeStatusChange->temporary) === '1' ? 'checked' : '' ?>>

      </p>
    </div>
  </div>
</div>

<input type="hidden" id="id" name="id" value="<?= $bikeStatusChange->id ?>">

</form>

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

<div class="modal">
  <div class="modal-background"></div>
  <div class="modal-card">

    <section class="modal-card-body" style="font-size: 15px !important; text-align: center !important; padding: 2px !important;">

    </section>
    <footer class="modal-card-foot">
      <button type="submit" form="incident_form" class="button is-success" style="width: 50% !important;">Dúng rồi. Nhập đi!</button>
      <button class="button is-danger close-toggle" style="width: 50% !important;">Tôi cần chỉnh lại</button>
    </footer>
  </div>
</div>

<script>
  //Form validation
  const form = document.querySelector('.random_class');


  //Modal stuff
  const modal = document.querySelector('.modal');
  const buttonOpenModal = document.querySelector('.toggle');
  const buttonCloseModal = document.querySelector('.close-toggle');

  const stringSegment1 = "Khách trả <b>";
  const stringSegment2 = "</b> đồng <br>cho <b>";
  const stringSegment3 = "</b> tháng. <br> Các con số này có đúng ko?";

  const toggle = function() {

    let amount = document.querySelector('input[name="amount"]');
    let months_paid = document.querySelector('input[name="months_paid"]');
    modal.classList.add('is-active');

    document.querySelector('.modal-card-body').innerHTML = `All information correct?`;

  };

  const closeToggle = function() {

    modal.classList.remove('is-active');

  };

  buttonOpenModal.addEventListener('click', toggle);
  buttonCloseModal.addEventListener('click', closeToggle);
</script>

<?= $this->endSection() ?>