<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Status Change<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?= form_open('Admin/Expenses/save', 'id="expense_form"') ?>

<?php if (session()->has('errors')): ?>
  <ul>
    <?php foreach(session('errors') as $error): ?>
      <li><?= $error ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>



<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="date">Ngày Trả Phí</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" type="date" name="date" id="date">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="amount">Giá Chi Phí</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" name="amount" id="amount">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="category">Danh Mục</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input list="parts_list" class="input is-success" id="category" name="category">
        <datalist id="parts_list">
          <?php foreach($expenseCategories as $expenseCategory): ?>
            <option value="<?= $expenseCategory['category'] ?>">
          <?php endforeach; ?>
        </datalist>
      </p>
    </div>
  </div>
</div>


<?php if($division === 'Dragon'): ?>
  <input type="hidden" name="dragon_bikes" value="1">
<?php elseif($division === 'SBR'): ?>
  <input type="hidden" name="dragon_bikes" value="0">
<?php endif; ?>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="notes">Thông Tin Thêm</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input type="textarea" class="input is-success" id="notes" name="notes">
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
      <button type="submit" form="expense_form" class="button is-success" style="width: 50% !important;">Dúng rồi. Nhập đi!</button>
      <button class="button is-danger close-toggle" style="width: 50% !important;">Tôi cần chỉnh lại</button>
    </footer>
  </div>
</div>

<script>
    const modal = document.querySelector('.modal');
    const buttonOpenModal = document.querySelector('.toggle');
    const buttonCloseModal = document.querySelector('.close-toggle');

    const toggle = function() {

      //let total = document.querySelector('input[name="total_cost"]');
      //let labor = document.querySelector('input[name="labor_cost"]');

      let message = `Tất cả các tông tin này có đúng ko?`;

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
