<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Input Parking Records<?= $this->endSection() ?>

<?= $this->section("content") ?>

<form action="" style="margin-bottom: 10px;">
  <input type="hidden" name="location" value="garage">
  <?php if (session()->get('user_level') == 'super') : ?>
    <div class="field" id="location">
      <div class="control">
        <label class="radio">
          <input type="radio" name="location" value="garage" checked>
          Garage
        </label>
        <label class="radio">
          <input type="radio" name="location" value="home">
          Home
        </label>
        <label class="radio">
          <input type="radio" name="location" value="sym">
          SYM
        </label>
        <label class="radio">
          <input type="radio" name="location" value="tay">
          Tay
        </label>
      </div>
    </div>
  <?php endif; ?>

  <div class="field is-horizontal" style="bottom: 200px !important;" id="original">
    <div class="field-label is-normal">
      <label class="label">Biển Số Xe
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autofocus autocomplete="off" list="current_bikes" class="input is-success" id="plate_number" name="plate_number1">
              <datalist id="current_bikes">
                <?php foreach ($currentBikes as $currentBike) : ?>
                  <option value="<?= $currentBike->plate_number ?>">
                  <?php endforeach; ?>
              </datalist>
            </p>
          </div>
        </div>
      </label>
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
        <button class="button is-link is-large is-fullwidth" id="addBike">
          Lưu Thêm Xe
        </button>
      </div>
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
        <button class="button is-danger is-large is-fullwidth" id="removeBike">
          Xóa Biển Số
        </button>
      </div>
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
        <button class="button is-success is-large is-fullwidth" id="sendData">
          Gưi Hết
        </button>
      </div>
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
        <a href="<?= site_url('Admin/Home') ?>">
          <button class="button is-warning is-large is-fullwidth">
            Trang Chính
          </button>
        </a>
      </div>
    </div>
  </div>
</div>

<script>
  const form = document.querySelector('form');
  const original = document.querySelector('#original');
  const plateNumber = document.querySelector('#plate_number');
  const locationRadio = document.querySelector('#location');
  const addBike = document.querySelector('#addBike');
  let inputCount = 1;
  let currentValues = [];
  let latestInput = original.querySelector('input');
  let latestInputContainer;

  const addNewInput = () => {
    latestInput.value = latestInput.value.trim();
    console.log(currentValues);
    if (!(currentValues.includes(latestInput.value) || latestInput.value === '')) {
      inputCount += 1;
      let newInput = original.cloneNode(true);
      newInput.removeAttribute('id');
      const input = newInput.querySelector('input');
      input.setAttribute('name', 'plate_number' + inputCount);
      input.value = "";
      latestInput = input;
      form.appendChild(newInput);
      latestInputContainer = newInput;
      currentValues.push(newInput.previousElementSibling.querySelector('input').value);
    } else {
      alert("Biển Số Ko Đúng!");
      latestInput.value = '';
    }
  }

  addBike.addEventListener('click', addNewInput);

  const removeBike = document.querySelector('#removeBike');
  const remove = () => {
    if (currentValues.length > 0) {
      let precedingVal = latestInputContainer.previousElementSibling.querySelector('input').value;
      currentValues = currentValues.filter(val => val !== precedingVal);
      let newLatest = latestInputContainer.previousElementSibling;
      latestInputContainer.remove();
      latestInputContainer = newLatest;
      latestInput = latestInputContainer.querySelector('input');
    }
  };

  removeBike.addEventListener('click', remove);

  const sendDataButton = document.querySelector('#sendData');

  const clearForm = () => {
    form.innerHTML = '';
    form.appendChild(locationRadio);
    form.appendChild(original);
    plateNumber.value = '';
  };

  const sendData = () => {
    if (currentValues.length > 0 || latestInput.value.trim() !== '') {
      let form = new FormData(document.forms[0]);
      const url = new URL(location.href);
      const origin = url.origin;
      const endPoint = origin + '/Admin/ParkedInGarage/saveRecords';

      fetch(endPoint, {
          method: 'POST',
          body: form,
        }).then((response) => response.json())
        .then((json) => alert(json.message))
        .then(() => clearForm());
    };
  }

  sendDataButton.addEventListener('click', sendData);
</script>

<?= $this->endSection() ?>