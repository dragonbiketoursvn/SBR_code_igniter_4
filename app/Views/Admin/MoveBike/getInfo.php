<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Status Change<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?= form_open('Admin/MoveBike/save', 'id="status_change"') ?>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="plate_number">Chọn Biển Số Xe</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input list="current_bikes" class="input is-success" id="plate_number" name="plate_number">
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
    <label class="label" for="new_status">Chọn Nơi Mới</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input list="locations" class="input is-success" id="new_status" name="new_status">
        <datalist id="locations">
          <option value="Nguyễn Thái Học">
          <option value="Quận 4">
          <option value="Honda">
          <option value="Yamaha">
          <option value="SYM">
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

    const toggle = function() {

      let plate_number = document.querySelector('input[name="plate_number"]');
      let new_status = document.querySelector('input[name="new_status"]');

      let message = `Xe biển số ${plate_number.value} được chuyển qua ${new_status.value}, đúng ko?`;

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
