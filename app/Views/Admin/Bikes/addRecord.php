<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Add New Bike Record<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php if (session()->has('errors')) : ?>
  <ul>
    <?php foreach (session('errors') as $error) : ?>
      <li>
        <?= $error ?>
      <li>
      <?php endforeach; ?>
      <ul>
      <?php endif; ?>

      <div class="field is-horizontal">
        <div class="field-label">
          <!-- Left empty for spacing -->
        </div>
        <div class="field-body">
          <div class="field">
            <div class="control">
              <a href="<?= site_url('Admin/Home') ?>">
                <button class="button is-warning is-large is-fullwidth">
                  Back to Main Menu
                </button>
              </a>
            </div>
          </div>
        </div>
      </div>

      <?= form_open_multipart('Admin/Bikes/saveRecord', 'id="new_record"') ?>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label class="label" for="plate_number">Plate Number</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autofocus required autocomplete="off" class="input is-success plate_number" id="plate_number" name="plate_number" value="<?= old('plate_number') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label class="label" for="purchase_date">Purchase Date</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input required autocomplete="off" type="date" class="input is-success purchase_date" id="purchase_date" name="purchase_date" value="<?= old('purchase_date') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label class="label" for="brand">Brand</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input required autocomplete="off" list="brand_list" class="input is-success" id="brand" name="brand" value="<?= old('brand') ?>">
              <datalist id="brand_list">
                <option value="HONDA">
                <option value="YAMAHA">
                <option value="SYM">
              </datalist>
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label class="label" for="model">Model</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input required autocomplete="off" list="model_list" class="input is-success" id="model" name="model" value="<?= old('model') ?>">
              <datalist id="model_list">
                <?php foreach ($currentModels as $currentModel) : ?>
                  <option value="<?= $currentModel->model ?>">
                  <?php endforeach; ?>
              </datalist>
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label type="tel" class="label" for="year">Year</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input required autocomplete="off" class="input is-success" id="year" name="year" value="<?= old('year') ?>">
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label class="label" for="purchase_price">Purchase Price</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input required autocomplete="off" type="tel" class="input is-success" id="purchase_price" name="purchase_price" value="<?= old('purchase_price') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label" for="giay_uy_quyen">Giấy Ủy Quyền?</label>
        </div>
        <div class="field-body">
          <div class="field">
            <label class="checkbox">
              <input type="hidden" name="giay_uy_quyen" value=0>
              <input type="checkbox" name="giay_uy_quyen" value=1>
            </label>
          </div>
        </div>
      </div>

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label" for="Nga_dung_ten">Nga đứng tên?</label>
        </div>
        <div class="field-body">
          <div class="field">
            <label class="checkbox">
              <input type="hidden" name="Nga_dung_ten" value=0>
              <input type="checkbox" name="Nga_dung_ten" value=1>
            </label>
          </div>
        </div>
      </div>

      <div class="field is-horizontal">
        <div class="field-label is-normal">
          <label class="label" for="dragon_bikes">Dragon Bikes</label>
        </div>
        <div class="field-body">
          <div class="field">
            <label class="checkbox">
              <input type="hidden" name="dragon_bikes" value=0>
              <input type="checkbox" name="dragon_bikes" value=1>
            </label>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label class="label" for="insurance_expires">Insurance Expires On</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autocomplete="off" type="date" class="input is-success insurance_expires" id="insurance_expires" name="insurance_expires" value="<?= old('purchase_date') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="photoSection">
        <div class="photoBox" data-image="unloaded">
          <div class="photoCaption">Side</div>
          <img class="photoImage" src="">
          <div class="deleteButton">Delete</div>
          <label class="selectPhoto" for="pic_side">Select Photo</label>
          <input autocomplete="off" type="file" class="photoInput" id="pic_side" name="pic_side">
        </div>

        <div class="photoBox" data-image="unloaded">
          <div class="photoCaption">Front</div>
          <img class="photoImage" src="">
          <div class="deleteButton">Delete</div>
          <label class="selectPhoto" for="pic_front">Select Photo</label>
          <input autocomplete="off" type="file" class="photoInput" id="pic_front" name="pic_front">
        </div>

        <div class="photoBox" data-image="unloaded">
          <div class="photoCaption">Rear</div>
          <img class="photoImage" src="">
          <div class="deleteButton">Delete</div>
          <label class="selectPhoto" for="pic_rear">Select Photo</label>
          <input autocomplete="off" type="file" class="photoInput" id="pic_rear" name="pic_rear">
        </div>

        <div class="photoBox" data-image="unloaded">
          <div class="photoCaption">Trunk</div>
          <img class="photoImage" src="">
          <div class="deleteButton">Delete</div>
          <label class="selectPhoto" for="pic_trunk">Select Photo</label>
          <input autocomplete="off" type="file" class="photoInput" id="pic_trunk" name="pic_trunk">
        </div>

      </div>

      <div class="photoSection">
        <div class="photoBox" data-image="unloaded">
          <div class="photoCaption">Registration (Front)</div>
          <img class="photoImage" src="">
          <div class="deleteButton">Delete</div>
          <label class="selectPhoto" for="reg_front">Select Photo</label>
          <input autocomplete="off" type="file" class="photoInput" id="reg_front" name="reg_front">
        </div>

        <div class="photoBox" data-image="unloaded">
          <div class="photoCaption">Registration (Back)</div>
          <img class="photoImage" src="">
          <div class="deleteButton">Delete</div>
          <label class="selectPhoto" for="reg_back">Select Photo</label>
          <input autocomplete="off" type="file" class="photoInput" id="reg_back" name="reg_back">
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
              <button type="submit" form="new_record" class="button is-link is-large is-fullwidth" id="addRecord">
                Add Record
              </button>
            </div>
          </div>
        </div>
      </div>
      </div>

      <script>
        // Create consts for the UNIQUE individual page elements plus consts for the other elements taken as UNIQUE groups.
        // This is necessary so that we can set event listeners that will change the state of individual components while leaving
        // other, identical components unaffected.

        const photoBoxes = document.querySelectorAll('.photoBox'); // boxes for displaying/editing photos associated with record
        const photoCaptions = document.querySelectorAll('.photoCaption'); // captions for each photo
        const photoImages = document.querySelectorAll('.photoImage'); // the img elements in each photoBox
        const deleteButtons = document.querySelectorAll('.deleteButton'); // delete buttons for each photo
        const photoInputs = document.querySelectorAll('.photoInput'); // photo inputs remain hidden
        const selectPhotos = document.querySelectorAll('.selectPhoto'); // 'selectPhoto' buttons, which display during edit mode in photoBoxes which have no image

        // Fore each photoImage that loads set its photoBox's data-image attribute to "loaded" (default is "unloaded")
        photoImages.forEach(function(e) {
          e.addEventListener('load', function() {
            e.parentNode.dataset.image = "loaded";
          });
        });

        // Set all elements to correct initial state when page loads (showing a success message if a record was just inserted)
        window.onload = function() {

          let success = "<?php
                          if (isset($success)) {
                            echo 'success';
                          } else {
                            echo '';
                          }
                          ?>";

          if (success == "success") {
            alert(success);
          }
          deleteButtons.forEach((e) => e.classList.add('hidden')); // hide the delete buttons
          photoInputs.forEach((e) => e.classList.add('hidden')); // hide each of the photo inputs
          photoImages.forEach((e) => e.classList.add('hidden')); // hide the img elements since they're empty

        }

        // Have the delete button asynchronously call the deleteCustomerPhoto controller
        deleteButtons.forEach((e) => e.addEventListener('click', function(e) {

          // And remove the image from page by setting src to empty string
          e.target.previousElementSibling.src = '';

          // Since there's currently nothing to delete, hide the button
          e.target.classList.add('hidden');

          // Remove any previously selected image from the file input so we don't upload it
          input = e.target.parentNode.querySelector('input');
          input.value = '';

          // Show our little selectPhoto tag and hide the empty img
          const selectPhoto = e.target.parentNode.querySelector('.selectPhoto');
          selectPhoto.classList.remove('hidden');
          e.target.previousElementSibling.classList.add('hidden');

        }));


        // Once we've successfully selected a file the change event fires and our callback is invoked
        photoInputs.forEach((e) => e.addEventListener('change', function(event) {

          // Set constants for the photoInput's parent photoBox and its sibling photoImage, deleteButon, and selectPhoto
          const photoBox = event.target.parentNode;
          const photoImage = photoBox.querySelector('.photoImage');
          const deleteButton = photoBox.querySelector('.deleteButton');
          const selectPhoto = photoBox.querySelector('.selectPhoto');

          // Assign file selected by input (via the input's files attribute) to const file
          const file = event.target.files[0];

          // Exit if no file was selected
          if (!file) return;

          // Create a FileReader object 
          const reader = new FileReader();

          // Read file into reader as DataURL
          reader.readAsDataURL(file);

          // Once read operation has successfully finished, set photoImage's src attribute to the value of the reader's 
          // result property (in this case a DataURL)
          // Then unhide photoImage and deletButton and hide selectPhoto
          reader.onload = function(event) {

            photoImage.src = event.target.result;
            photoImage.classList.remove('hidden');
            deleteButton.classList.remove('hidden');
            selectPhoto.classList.add('hidden');
          }

        }));


        // Want to make sure no duplicate records are added so let's stick plate numbers of all current bikes in an array
        // And before the form submits we'll check that the plate number being submitted isn't already in the array
        const plate_number = document.querySelector('#plate_number');
        const plate_numbers = [
          <?php

          foreach ($currentBikes as $currentBike) {
            echo "'" . $currentBike->plate_number . "', ";
          }

          ?>
        ];

        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
          if (plate_numbers.includes(plate_number.value)) {
            e.preventDefault();
            alert('Duplicate Record!');
          }
        })
      </script>

      <?= $this->endSection() ?>