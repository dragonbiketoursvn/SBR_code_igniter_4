<?= $this->extend("layouts/default") ?>


<?= $this->section('title') ?>Expense Form<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="block">
  <section class="hero is-success">
    <div class="hero-body has-text-centered" style="margin-bottom: 0px;">
      <p class="title">
        Expense Form
      </p>
    </div>
  </section>
</div>

<?php if (session()->has('errors')): ?>
  <div class="block">
    <ul>
      <?php foreach (session('errors') as $error): ?>
        <li style="color: tomato;"><b><?= $error ?></b></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?= form_open('Admin/Expenses/saveUpdate', 'id="expense_form" class="random_class"') ?>

<input type="hidden" name="id" value="<?= esc($expense->id) ?>">

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="date">Date</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input class="input is-success" type="date" id="date" name="date" value="<?= esc($expense->date) ?>">
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="amount">Amount</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input required class="input is-success" type="text" id="amount" name="amount" value="<?= esc($expense->amount) ?>">
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="category">Category</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input required class="input is-success" type="text" id="category" name="category" value="<?= esc($expense->category) ?>">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="notes">Notes</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" type="text" id="notes" name="notes" value="<?= esc($expense->notes) ?>">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="notes">Biển Số Xe</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autofocus autocomplete="off" list="current_bikes" class="input is-success" id="plate_number" name="plate_number"
          value="<?= esc($expense->plate_number) ?>">
        <datalist id="current_bikes">
          <?php foreach ($currentBikes as $currentBike) : ?>
            <option value="<?= $currentBike->plate_number ?>">
            <?php endforeach; ?>
        </datalist>
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="quantity">Quantity</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" type="text" id="quantity" name="quantity" value="<?= esc($expense->quantity) ?>">
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
          Update
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
  //Form validation
  const form = document.querySelector('.random_class');

  const validator = function(e) {

    let amount = document.querySelector('input[name="amount"]');
    let months_paid = document.querySelector('input[name="months_paid"]');
    errorMessages = [];

    if (amount.value > 10001 || amount.value < 500) {

      errorMessages.push('Khoản tiền này ko phù hợp');

    }

    if (months_paid.value > 8 || months_paid.value < 0) {

      errorMessages.push('Số tháng này ko phù hợp');

    }

    if (errorMessages.length > 0) {

      alert(errorMessages.join(', '));
      e.preventDefault();
    }
  };

  form.addEventListener('submit', validator);


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

    document.querySelector('.modal-card-body').innerHTML = `${stringSegment1}${amount.value}${stringSegment2}${months_paid.value}${stringSegment3}`;

  };

  const closeToggle = function() {

    modal.classList.remove('is-active');

  };

  buttonOpenModal.addEventListener('click', toggle);
  buttonCloseModal.addEventListener('click', closeToggle);
</script>

<?= $this->endSection() ?>