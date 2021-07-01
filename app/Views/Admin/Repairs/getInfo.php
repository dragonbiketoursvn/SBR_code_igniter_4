<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Status Change<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?= form_open('Admin/Repairs/save', 'id="repair_form"') ?>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="plate_number">Biển Số Xe</label>
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
    <label class="label" for="repair_date">Ngày Sửa</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" type="date" name="repair_date" id="repair_date">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="ododmeter">Đồng Hồ</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" name="ododmeter" id="ododmeter">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="total_cost">Tổng Cộng</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" name="total_cost" id="total_cost">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="labor_cost">Tiền Công</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" name="labor_cost" id="labor_cost">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="nhot">Nhớt</label>
  </div>
  <div class="field-body">
    <div class="field">
      <label class="checkbox">
        <input type="hidden" name="nhot" value=0>
        <input type="checkbox">
      </label>
    </div>
  </div>
</div>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="item_1">Phụ Tùng 1</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input list="parts_list" class="input is-success" id="item_1" name="item_1">
        <datalist id="parts_list">
          <?php foreach($partsList as $part): ?>
            <option value="<?= $part->part_name ?>">
          <?php endforeach; ?>
        </datalist>
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="item_2">Phụ Tùng 2</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input list="parts_list" class="input is-success" id="item_2" name="item_2">
        <datalist id="parts_list">
          <?php foreach($partsList as $part): ?>
            <option value="<?= $part->part_name ?>">
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
      <button type="submit" form="repair_form" class="button is-success" style="width: 50% !important;">Dúng rồi. Nhập đi!</button>
      <button class="button is-danger close-toggle" style="width: 50% !important;">Tôi cần chỉnh lại</button>
    </footer>
  </div>
</div>

<script>
    const modal = document.querySelector('.modal');
    const buttonOpenModal = document.querySelector('.toggle');
    const buttonCloseModal = document.querySelector('.close-toggle');

    const toggle = function() {

      let total = document.querySelector('input[name="total_cost"]');
      let labor = document.querySelector('input[name="labor_cost"]');

      let message = `Giá tổng cộng là ${total.value} và tiền công là ${labor.value}, đúng ko?`;

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
