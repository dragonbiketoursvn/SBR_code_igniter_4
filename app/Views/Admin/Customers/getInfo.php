<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Customer Info<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php if(session()->has('errors')): ?>
  <p>
    <?= session()->get('errors') ?>
  </p>
<?php endif; ?>

<?= form_open('Admin/Customers/viewInfo', 'id="select_form"') ?>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="customer_name">Select Customer</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input list="customers" class="input is-success" id="customer_name" name="customer_name">
        <datalist id="customers">
          <?php foreach($customers as $customer): ?>
            <option value="<?= $customer->customer_name ?>">
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
          Submit
        </button>
      </div>
    </div>
  </div>
</div>

</form>

<?= $this->endSection() ?>
