<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Status Change<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?= form_open('Admin/Repairs/showHistory') ?>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="plate_number">Biển Số Xe</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autofocus autocomplete="off" list="current_bikes" class="input is-success" id="plate_number" name="plate_number">
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
  <div class="field-label">
    <!-- Left empty for spacing -->
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <button class="button is-available is-large is-fullwidth">
          Xem Lịch Sự Sửa Chữa
        </button>
      </div>
    </div>
  </div>
</div>

</form>

<?= $this->endSection() ?>