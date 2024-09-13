<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Customer Info<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php
if (!$repair) {
  return redirect()->back();
}
?>

<!-- This remains hidden until user presses 'Show Customer Details' button  -->

<?= form_open('Admin/Repairs/updateOrDelete') ?>

<input type="hidden" name="id" value="<?= $repair->id ?>">

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="plate_number" style="color:red; font-weight:bold;">Plate Number</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autocomplete="off" class="input is-success" id="plate_number" name="plate_number" value="<?= $repair->plate_number ?>">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="repair_date">Repair Date</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autocomplete="off" class="input is-success repair_date"
          id="repair_date" name="customer_name" value="<?= $repair->repair_date ?>">
      </p>
    </div>
  </div>
</div>

<div class="customer_info">

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="odometer">Odometer</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" class="input is-success" id="odometer" name="odometer" value="<?= $repair->odometer ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="total_cost">Total Cost</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" class="input is-success" id="total_cost"
            name="total_cost" value="<?= $repair->total_cost ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="labor_cost">Labor Cost</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" class="input is-success" id="labor_cost"
            name="labor_cost" value="<?= $repair->labor_cost ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="nhot">Nhớt</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" class="input is-success" id="nhot"
            name="nhot" value="<?= $repair->nhot ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="item_1">Item 1</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" list="part_list" class="input is-success" id="item_1" name="item_1" value="<?= $repair->item_1 ?? ''; ?>">
          <datalist id="part_list">
            <?php foreach ($parts as $part) : ?>
              <option value="<?= $part->part_name ?>">
              <?php endforeach; ?>
          </datalist>
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="item_2">Item 2</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" list="part_list" class="input is-success" id="item_2" name="item_2" value="<?= $repair->item_2 ?? ''; ?>">
          <datalist id="part_list">
            <?php foreach ($parts as $part) : ?>
              <option value="<?= $part->part_name ?>">
              <?php endforeach; ?>
          </datalist>
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="item_3">Item 3</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" list="part_list" class="input is-success" id="item_3" name="item_3" value="<?= $repair->item_3 ?? ''; ?>">
          <datalist id="part_list">
            <?php foreach ($parts as $part) : ?>
              <option value="<?= $part->part_name ?>">
              <?php endforeach; ?>
          </datalist>
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="item_4">Item 4</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" list="part_list" class="input is-success" id="item_4" name="item_4" value="<?= $repair->item_4 ?? ''; ?>">
          <datalist id="part_list">
            <?php foreach ($parts as $part) : ?>
              <option value="<?= $part->part_name ?>">
              <?php endforeach; ?>
          </datalist>
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="item_5">Item 5</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" list="part_list" class="input is-success" id="item_5" name="item_5" value="<?= $repair->item_5 ?? ''; ?>">
          <datalist id="part_list">
            <?php foreach ($parts as $part) : ?>
              <option value="<?= $part->part_name ?>">
              <?php endforeach; ?>
          </datalist>
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="item_6">Item 6</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" list="part_list" class="input is-success" id="item_6" name="item_6" value="<?= $repair->item_6 ?? ''; ?>">
          <datalist id="part_list">
            <?php foreach ($parts as $part) : ?>
              <option value="<?= $part->part_name ?>">
              <?php endforeach; ?>
          </datalist>
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="item_7">Item 7</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" list="part_list" class="input is-success" id="item_7" name="item_7" value="<?= $repair->item_7 ?? ''; ?>">
          <datalist id="part_list">
            <?php foreach ($parts as $part) : ?>
              <option value="<?= $part->part_name ?>">
              <?php endforeach; ?>
          </datalist>
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="item_8">Item 8</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" list="part_list" class="input is-success" id="item_8" name="item_8" value="<?= $repair->item_8 ?? ''; ?>">
          <datalist id="part_list">
            <?php foreach ($parts as $part) : ?>
              <option value="<?= $part->part_name ?>">
              <?php endforeach; ?>
          </datalist>
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="item_9">Item 9</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" list="part_list" class="input is-success" id="item_9" name="item_9" value="<?= $repair->item_9 ?? ''; ?>">
          <datalist id="part_list">
            <?php foreach ($parts as $part) : ?>
              <option value="<?= $part->part_name ?>">
              <?php endforeach; ?>
          </datalist>
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="item_10">Item 10</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" list="part_list" class="input is-success" id="item_10" name="item_10" value="<?= $repair->item_10 ?? ''; ?>">
          <datalist id="part_list">
            <?php foreach ($parts as $part) : ?>
              <option value="<?= $part->part_name ?>">
              <?php endforeach; ?>
          </datalist>
        </p>
      </div>
    </div>
  </div>

</div>


<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="delete" style="color: red;">Delete?</label>
  </div>
  <div class="field-body">
    <div class="field">
      <label class="checkbox">
        <input type="hidden" name="delete" value=0>
        <input type="checkbox" name="delete" value=1>
      </label>
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
          Update
        </button>
      </div>
    </div>
  </div>
</div>

</form>

<script src="<?= site_url('js/Customers/viewInfo.js'); ?>"></script>
<script src="<?= site_url('js/Customers/currencyConversion5.js') ?>"></script>

<?= $this->endSection() ?>