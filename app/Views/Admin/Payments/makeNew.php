<?= $this->extend("layouts/default") ?>


<?= $this->section('title') ?>Payment Form<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="block">
  <section class="hero is-success">
    <div class="hero-body has-text-centered" style="margin-bottom: 0px;">
      <p class="title">
       Phiếu Thu Tiền
      </p>
    </div>
  </section>
</div>

<?php if(session()->has('errors')): ?>
  <div class="block">
    <ul>
      <?php foreach(session('errors') as $error): ?>
        <li style="color: tomato;"><b><?= $error ?></b></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?= form_open('Admin/Payments/savePayment', 'id="payment_form" class="random_class"') ?>

<input type="hidden" name="customer_id" value="<?= esc($appointment->customer_id) ?>">

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="customer_name">Tên Khách</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input required readonly class="input is-success" type="text" id="customer_name" name="customer_name" value="<?= esc($appointment->customer_name) ?>">
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="amount">Khoản Tiền (x1000 đồng)</label>
  </div>
  <div class="field-body">
    <div class="field">
        <input autofocus required autocomplete="off" class="input is-success" type="text" id="amount" name="amount" value="<?= old('amount') ?>">
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="months_paid">Trả Mấy Tháng</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input required autocomplete="off" class="input is-success" type="text" id="months_paid" name="months_paid" value="<?= old('months_paid') ?>">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="payment_date">Ngày Trả</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input required autocomplete="off" readonly class="input is-success" type="text" id="payment_date" name="payment_date" value="<?= date('Y-m-d') ?>">
      </p>
    </div>
  </div>
</div>

<?php if (session()->get('user_level') == 'super') : ?>

  <div class="field">
  <div class="control">
    <label class="radio">
      <input type="radio" name="payment_method" value="cash" checked>
      Cash
    </label>
    <label class="radio">
      <input type="radio" name="payment_method" value="bank_tranfer">
      Bank Transfer
    </label>
    <label class="radio">
      <input type="radio" name="payment_method" value="paypal">
      PayPal
    </label>
  </div>
</div>

<?php endif; ?>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="notes">Thông Tin Thêm</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autocomplete="off" class="input is-success" type="text" id="notes" name="notes" value="<?= old('notes') ?>">
      </p>
    </div>
  </div>
</div>


<input type="hidden" name="payment_method" value="cash">

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
      <button type="submit" form="payment_form" class="button is-success" style="width: 50% !important;">Dúng rồi. Nhập đi!</button>
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

  if(amount.value > 10001 || amount.value < 500) {

    errorMessages.push('Khoản tiền này ko phù hợp');

  }

  if(months_paid.value > 8 || months_paid.value < 0) {

    errorMessages.push('Số tháng này ko phù hợp');

  }

  if(errorMessages.length > 0) {

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