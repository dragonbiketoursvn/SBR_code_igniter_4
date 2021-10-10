<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Tạo Cuộc Hẹn Mới<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?= form_open('Admin/Appointments/saveNew') ?>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="customer">Chọn Khách</label>
  </div>
      <div class="field-body">
        <div class="field">
          <p class="control is-expanded">
            <input autofocus required autocomplete="off" list="current_customers" class="input is-success" name="customer_name">
            <datalist id="current_customers">
              <?php foreach($currentCustomers as $currentCustomer): ?>
                <option value="<?= $currentCustomer->customer_name ?>">
              <?php endforeach; ?>
            </datalist>
          </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label">
    <!-- Left empty for spacing -->
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <button class="button is-available is-large is-fullwidth toggle">
          Xác Nhận
        </button>
      </div>
    </div>
  </div>
</div>

</form>


<?= $this->endSection() ?>
