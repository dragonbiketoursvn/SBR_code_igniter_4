<?= $this->extend("layouts/default") ?>


<?= $this->section('title') ?>Location Selector<?= $this->endSection() ?>

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


<?= form_open('Admin/Payments/savePayment') ?>

<input type="hidden" name="contract_number" value="<?= esc($appointment->contract_number) ?>">

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="customer_name">Tên Khách</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input readonly class="input is-success" type="text" id="customer_name" name="customer_name" value="<?= esc($appointment->customer_name) ?>">
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="amount">Khoản Tiền</label>
  </div>
  <div class="field-body">
    <div class="field">
        <input class="input is-success" type="text" id="amount" name="amount">
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
        <input class="input is-success" type="text" id="months_paid" name="months_paid">
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
        <input readonly class="input is-success" type="text" id="payment_date" name="payment_date" value="<?= date('Y-m-d') ?>">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="notes">Thông Tin Thêm</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" type="text" id="notes" name="notes">
      </p>
    </div>
  </div>
</div>


<input type="hidden" name="payment_method" value="cash">

<div class="field is-horizontal">
  <div class="field-label">
    <!-- Left empty for spacing -->
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <button class="button is-available is-large is-fullwidth" style="display: none;">
          Nhập Thông Tin
        </button>
      </div>
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
        <button class="button is-warning is-large is-fullwidth" id="before_confirmation">
          Xác Định
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  document.querySelector("#before_confirmation").addEventListener('click', function(){

    if(confirm('Các con số này có phải là đúng ko?')){

      document.querySelector('#before_confirmation').style.display = 'none';
      document.querySelector('button[style]').style.display = 'block';

    }
  })
</script>

<?= $this->endSection() ?>
