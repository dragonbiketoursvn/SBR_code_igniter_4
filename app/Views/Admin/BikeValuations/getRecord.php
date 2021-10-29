<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Nộp Giá Xe<?= $this->endSection() ?>

<?= $this->section("content") ?>

<!-- The values of these inputs will not be sent to the server -->

<div class="field is-horizontal is-justify-content-space-around">
    <div class="field">
    <label class="label">Hãng Xe</label>
    <div class="control">
        <div class="select">
        <select id="brand">
            <option value="Honda">Honda</option>
            <option value="Yamaha">Yamaha</option>
            <option value="SYM">SYM</option>
        </select>
        </div>
    </div>
    </div>

    <div class="field">
    <label class="label">Dòng Xe</label>
    <div class="control">
        <div class="select">
        <select id="model">
            <option value="Airblade">Airblade</option>
            <option value="Vision">Vision</option>
            <option value="Lead">Lead</option>
            <option value="Wave">Wave</option>
        </select>
        </div>
    </div>
    </div>

    <div class="field">
    <label class="label">Năm Đăng Ký</label>
    <div class="control">
        <div class="select">
            <select id="year">
            </select>
        </div>
    </div>
    </div>
</div>

<div class="field is-horizontal is-justify-content-space-around"">
<div class="field">
    <label class="label is-horizontal">Giá 1</label>
    <input required class="value" type="number" min="1000" max="50000" step="100">
</div>
<div class="field">
    <label class="label is-horizontal">Giá 2</label>
    <input required class="value" type="number" min="1000" max="50000" step="100">
</div>
<div class="field">
    <label class="label is-horizontal">Giá 3</label>
    <input required class="value" type="number" min="1000" max="50000" step="100">
</div>
<div class="field">
    <label class="label is-horizontal">Giá 4</label>
    <input required class="value" type="number" min="1000" max="50000" step="100">
</div>
<div class="field">
    <label class="label is-horizontal">Giá 5</label>
    <input required class="value" type="number" min="1000" max="50000" step="100">
</div>
    
</div>

<div class="field is-horizontal">
  <div class="field-label">
  <!-- Left empty for spacing -->
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <button class="button is-available is-large is-fullwidth toggle" form="formData">
          Nọp
        </button>
      </div>
    </div>
  </div>
</div>

<!-- This form holds the values to be sent to the server and will not be seen -->

<?= form_open('Admin/BikeValuations/addRecord', 'id="formData"') ?>
<input type="text" name="brand" id="formBrand"> 
    <input type="text" name="model" id="formModel">
    <input type="text" name="year" id="formYear">
    <input type="number" name="value" id="average_value">
    <input type="text" name="date_checked" id="formBrand">
</form>

<script>
        
        // Set constants for inputs outside of form
        const brand = document.querySelector('#brand');
        const model = document.querySelector('#model');
        const year = document.querySelector('#year');

        // We'll deal with the .value inputs as a single entity
        const values = document.querySelectorAll('.value');

        // Dynamically generate options for year select menu (so current year is always at top)
        const currentYear = new Date().getFullYear();
           
        for(let i = 0; i < 15; i++) {
            let yearOption = document.createElement('option');
            yearOption.value = yearOption.innerHTML = currentYear - i;
            year.appendChild(yearOption);
        }

        // Set constants for form inputs
        const formBrand = document.querySelector('#formBrand');
        const formModel = document.querySelector('#formModel');
        const formYear = document.querySelector('#formYear');


        brand.addEventListener('change', function() {
            formBrand.value = brand.value;
        })

        model.addEventListener('change', function() {
            formModel.value = model.value;
        })

        year.addEventListener('change', function() {
            formYear.value = year.value;
        })

        // Assign average_value input to a constant
        const average_value = document.querySelector('#average_value');

        // Function to get current average of all inputs of class .value and assign to average_value input
        const currentAvgValue = function (){
            let sum = 0;
            let elementCount = 0;

            values.forEach(function(input) {
                if (input.value > 0) {
                    sum += Number(input.value);
                    elementCount += 1;
                    average_value.value = sum / elementCount;
                } 
            });
        }

        // Add event listener to each input to update average price each time input value changes
        values.forEach(function(input) {
            input.addEventListener('input', currentAvgValue);
        })

        // Make sure that form inputs have default values when page loads
        window.onload = function() {
            formBrand.value = brand.value;
            formModel.value = model.value;
            formYear.value  = year.value;
            document.querySelector('#formData').style.display = 'none';
        }
        
    </script>


<?= $this->endSection() ?>
