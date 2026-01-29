<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Add New Household Item Record<?= $this->endSection() ?>

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

      <?= form_open_multipart('Admin/HouseholdItems/saveRecord', 'id="new_record"') ?>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label class="label" for="box">Box</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autofocus required autocomplete="off" class="input is-success box" id="box" name="box" value="<?= old('box') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label class="label" for="category_english">Category</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autocomplete="off" class="input is-success category_english" id="category_english" name="category_english" value="<?= old('category_english') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label class="label" for="description_english">Description</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autocomplete="off" class="input is-success" id="description" name="description" value="<?= old('description') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label class="label" for="category_vietnamese">Danh Mục</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autocomplete="off" class="input is-success" id="category_vietnamese" name="category_vietnamese" value="<?= old('category_vietnamese') ?>">
            </p>
          </div>
        </div>
      </div>

      <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label type="tel" class="label" for="description_vietnamese">Mô Tả</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autocomplete="off" class="input is-success" id="description_vietnamese" name="description_vietnamese" value="<?= old('description_vietnamese') ?>">
          </div>
        </div>
      </div>

      <div class="photoSection">
        <div class="photoBox" data-image="unloaded">
          <div class="photoCaption">Photo</div>
          <img class="photoImage" src="">
          <div class="deleteButton">Delete</div>
          <label class="selectPhoto" for="photo">Select Photo</label>
          <input required autocomplete="off" type="file" class="photoInput" id="photo" name="photo">
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
      </script>
      <script src="<?= site_url('js/ImageProcessing/compression2.js') ?>"></script>

      <?= $this->endSection() ?>