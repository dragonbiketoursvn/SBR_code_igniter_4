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
        <input autofocus required autocomplete="off" list="current_customers"
          class="input is-success" name="customer_name" id="customer_name">
        <datalist id="current_customers">
          <?php foreach ($currentCustomers as $currentCustomer): ?>
            <option value="<?= $currentCustomer->customer_name . ':' . $currentCustomer->id ?>">
            <?php endforeach; ?>
        </datalist>
        <datalist id="old-contract-list">
          <?php foreach ($formerCustomersOweMoney as $formerCustomer): ?>
            <option value="<?= $formerCustomer->customer_name . ':' . $formerCustomer->id ?>">
            <?php endforeach; ?>
        </datalist>
        <datalist id="owe-compensation-list">
          <?php foreach ($customersOweCompensation as $customer): ?>
            <option value="<?= $customer->customer_name . ':' . $customer->id ?>">
            <?php endforeach; ?>
        </datalist>
      </p>
    </div>
  </div>
</div>

<?php if (session()->get('user_level') == 'super') : ?>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="customer">Old Contract</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input type="checkbox" id="old-contract">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="compensation">Compensation</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input type="hidden" name="compensation" value="0">
          <input type="checkbox" id="compensation" name="compensation" value="1">
        </p>
      </div>
    </div>
  </div>

<?php endif; ?>

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

<script>
  const checkBoxOldContract = document.querySelector('#old-contract');
  const checkBoxCompensation = document.querySelector('#compensation');
  const customerName = document.querySelector('#customer_name');

  const oldContractCheckHandler = (e) => {
    if (e.target.checked) {
      customerName.setAttribute('list', 'old-contract-list');
      checkBoxCompensation.checked = false;
      customerName.value = '';
    } else {
      customerName.setAttribute('list', 'current_customers');
    }
  };

  const compensationCheckHandler = (e) => {
    if (e.target.checked) {
      customerName.setAttribute('list', 'owe-compensation-list');
      checkBoxOldContract.checked = false;
      customerName.value = '';
    } else {
      customerName.setAttribute('list', 'current_customers');
    }
  };

  checkBoxOldContract.addEventListener('change', oldContractCheckHandler);
  checkBoxCompensation.addEventListener('change', compensationCheckHandler);
</script>

<?= $this->endSection() ?>