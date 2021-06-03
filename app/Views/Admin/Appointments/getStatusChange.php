<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Status Change<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?= form_open('Admin/Appointments/saveStatusChange') ?>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="bike_out">Khách <span style="color: tomato;">NHẬN</span> Xe Biển Số Bao Nhiêu?</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input list="current_bikes" class="input is-success" id="bike_out" name="bike_out">
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
    <label class="label" for="bike_in">Khách <span style="color: tomato;">TRẢ LẠI</span> Xe Biển Số Bao Nhiêu?</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input list="current_bikes" class="input is-success" id="bike_in" name="bike_in">
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
