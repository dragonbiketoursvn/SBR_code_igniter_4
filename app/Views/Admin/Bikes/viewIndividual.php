<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>View Individual Profile<?= $this->endSection() ?>

<?= $this->section("content") ?>

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

<?= form_open_multipart(site_url('Admin/Bikes/updateRecord')) ?>

<div class="field is-horizontal plateNumberDiv" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="plate_number">Plate Number</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autofocus autocomplete="off" list="current_bikes" class="input is-success" id="plate_number" name="plate_number">
        <datalist id="current_bikes">
          <?php foreach ($currentBikes as $currentBike) : ?>
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
        <button class="button is-available is-large is-fullwidth viewProfile">
          View Profile
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
        <button class="button is-available is-large is-fullwidth selectNewProfile">
          Select New Profile
        </button>
      </div>
    </div>
  </div>
</div>

<div id="edit_button">
  <div class="field is-horizontal">
    <div class="field-label">
      <!-- Left empty for spacing -->
    </div>
    <div class="field-body">
      <div class="field">
        <div class="control">
          <button class="button is-success is-large is-fullwidth">
            Edit
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="update_button">
  <div class="field is-horizontal">
    <div class="field-label">
      <!-- Left empty for spacing -->
    </div>
    <div class="field-body">
      <div class="field">
        <div class="control">
          <button class="button is-success is-large is-fullwidth">
            Update
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="cancel_button">
  <div class="field is-horizontal">
    <div class="field-label">
      <!-- Left empty for spacing -->
    </div>
    <div class="field-body">
      <div class="field">
        <div class="control">
          <button class="button is-danger is-large is-fullwidth">
            Cancel Update
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="profile">

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="purchase_date">Purchase Date</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input required autocomplete="off" type="date" class="input is-success purchase_date" id="purchase_date" name="purchase_date">
        </p>
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
          <input required autocomplete="off" type="tel" class="input is-success purchase_price" id="purchase_price" name="purchase_price">
        </p>
      </div>
    </div>
  </div>


  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="purchased_from">Purchased From</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input required autocomplete="off" type="text" class="input is-success" id="purchased_from" name="purchased_from" value="<?= old('purchased_from') ?>">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="sale_date">Sale Date</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" type="date" class="input is-success sale_date" id="sale_date" name="sale_date">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="sale_price">Sale Price</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" type="tel" class="input is-success sale_price" id="sale_price" name="sale_price">
        </p>
      </div>
    </div>
  </div>

  <div class="field is-horizontal" style="bottom: 200px !important;">
    <div class="field-label is-normal">
      <label class="label" for="notes">Notes</label>
    </div>
    <div class="field-body">
      <div class="field">
        <p class="control is-expanded">
          <input autocomplete="off" type="text" class="input is-success notes" id="notes" name="notes">
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

  <div class="field is-horizontal">
    <div class="field-label is-normal">
      <label class="label" for="extra_key">Extra Key?</label>
    </div>
    <div class="field-body">
      <div class="field">
        <label class="checkbox">
          <input type="hidden" name="extra_key" value=0>
          <input type="checkbox" name="extra_key" id="extra_key" value=1>
        </label>
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
          <input type="checkbox" name="giay_uy_quyen" id="giay_uy_quyen" value=1>
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
          <input type="checkbox" name="Nga_dung_ten" id="Nga_dung_ten" value=1>
        </label>
      </div>
    </div>
  </div>

  <div class="field is-horizontal">
    <div class="field-label is-normal">
      <label class="label" for="Kim_Anh_dung_ten">Kim Anh đứng tên?</label>
    </div>
    <div class="field-body">
      <div class="field">
        <label class="checkbox">
          <input type="hidden" name="Kim_Anh_dung_ten" value=0>
          <input type="checkbox" name="Kim_Anh_dung_ten" id="Kim_Anh_dung_ten" value=1>
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
          <input type="checkbox" name="dragon_bikes" id="dragon_bikes" value=1>
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
      <div class="selectButton">Select</div>
      <div class="deselectButton">De-select</div>
    </div>

    <div class="photoBox" data-image="unloaded">
      <div class="photoCaption">Registration (Back)</div>
      <img class="photoImage" src="">
      <div class="deleteButton">Delete</div>
      <label class="selectPhoto" for="reg_back">Select Photo</label>
      <input autocomplete="off" type="file" class="photoInput" id="reg_back" name="reg_back">
      <div class="selectButton">Select</div>
      <div class="deselectButton">De-select</div>
    </div>

  </div>

</div>

</form>

<div class="mailForm">

  <div class="customerSelect">
    <label for="names">Select Customer</label>
    <select name="names" id="names">
      <option value=""></option>
      <?php foreach ($customers as $customer) : ?>
        <option value="<?= $customer->customer_name ?>"><?= $customer->customer_name ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <input type="email" class="email">
  <input type="textarea" class="messageBox">
  <div class="buttons">
    <button id="sendButton">Send</button>
    <button id="mailCancelButton">Cancel</button>
  </div>

</div>

<script>
  alert('testing c!')
  // Create constants for the plate_number input, the viewProfile button and the profile section itself
  const profile = document.querySelector('.profile');
  const viewProfile = document.querySelector('.viewProfile');
  const selectNewProfile = document.querySelector('.selectNewProfile');
  const plateNumber = document.querySelector('#plate_number');
  const plateNumberDiv = document.querySelector('.plateNumberDiv');

  // And constants for all the other inputs and buttons
  const editButton = document.querySelector('#edit_button');
  const updateButton = document.querySelector('#update_button');
  const cancelButton = document.querySelector('#cancel_button');
  const purchaseDate = document.querySelector('#purchase_date');
  const purchasedFrom = document.querySelector('#purchased_from');
  const purchasePrice = document.querySelector('#purchase_price');
  const saleDate = document.querySelector('#sale_date');
  const salePrice = document.querySelector('#sale_price');
  const notes = document.querySelector('#notes');
  const brand = document.querySelector('#brand');
  const model = document.querySelector('#model');
  const year = document.querySelector('#year');
  const extraKey = document.querySelector('#extra_key');
  const giayUyQuyen = document.querySelector('#giay_uy_quyen');
  const NgaDungTen = document.querySelector('#Nga_dung_ten');
  const KimAnhDungTen = document.querySelector('#Kim_Anh_dung_ten');
  const DragonBikes = document.querySelector('#dragon_bikes');
  const insuranceExpires = document.querySelector('#insurance_expires');
  const picSide = document.querySelector('#pic_side');
  const picFront = document.querySelector('#pic_front');
  const picTrunk = document.querySelector('#pic_trunk');
  const picRear = document.querySelector('#pic_rear');
  const regFront = document.querySelector('#reg_front');
  const regBack = document.querySelector('#reg_back');

  // And a constant for all inputs in the profile so that we can initally set them all to readonly
  const inputs = profile.querySelectorAll('input');

  // And an event listener on the editButton to remove the readonly attribute when it's clicked
  editButton.addEventListener('click', function(event) {
    event.preventDefault();
    inputs.forEach(e => e.removeAttribute('readonly'));
    updateButton.classList.remove('hidden');
    cancelButton.classList.remove('hidden');
    event.target.classList.add('hidden');
  })

  // Add event listeners on cancelButton and selectNewProfile to refresh the page
  cancelButton.addEventListener('click', function(e) {
    location.reload();
  });

  selectNewProfile.addEventListener('click', function(e) {
    location.reload();
  });

  // Hide the profile and edit button when the page loads and set all inputs to readonly
  window.addEventListener('load', function(e) {
    profile.classList.add('hidden');
    editButton.classList.add('hidden');
    updateButton.classList.add('hidden');
    cancelButton.classList.add('hidden');
    selectNewProfile.classList.add('hidden');
  });

  // This section of code is for selecting a bike and asynchronously obtaining its profile info from
  // the Bikes/showProfile() controller.
  // When the viewProfile button is clicked, make an async post request to Bikes/showProfile()
  // If we get json back display the profile, inserting relevant values returned by controller
  // and displaying any photos.
  viewProfile.addEventListener('click', function(e) {

    const formData = new FormData();

    formData.append('plate_number', plateNumber.value);

    fetch("<?= site_url('Admin/Bikes/showProfile') ?>", {
      method: 'POST',
      body: formData
    }).then(response => response.json()).then(function(json) {
      if (json !== null) {
        // Update all the inputs
        profile.classList.remove('hidden');
        purchaseDate.value = json.purchase_date;
        purchasedFrom.value = json.purchased_from;
        purchasePrice.value = json.purchase_price;
        saleDate.value = json.sale_date;
        salePrice.value = json.sale_price;
        notes.value = json.notes;
        brand.value = json.brand;
        model.value = json.model;
        year.value = json.year;
        extraKey.checked = ((json.extra_key === '1') ? true : false);
        giayUyQuyen.checked = ((json.giay_uy_quyen === '1') ? true : false);
        NgaDungTen.checked = ((json.Nga_dung_ten === '1') ? true : false);
        KimAnhDungTen.checked = ((json.Kim_Anh_dung_ten === '1') ? true : false);
        DragonBikes.checked = ((json.dragon_bikes === '1') ? true : false);
        insuranceExpires.value = json.insurance_expires;

        // Display any photos
        picSide.parentNode.querySelector('img').src = "<?= site_url('Admin/Bikes/displayBikePhoto/') ?>" + json.pic_side;
        picFront.parentNode.querySelector('img').src = "<?= site_url('Admin/Bikes/displayBikePhoto/') ?>" + json.pic_front;
        picRear.parentNode.querySelector('img').src = "<?= site_url('Admin/Bikes/displayBikePhoto/') ?>" + json.pic_rear;
        picTrunk.parentNode.querySelector('img').src = "<?= site_url('Admin/Bikes/displayBikePhoto/') ?>" + json.pic_trunk;
        regFront.parentNode.querySelector('img').src = "<?= site_url('Admin/Bikes/displayRegPhoto/') ?>" + json.reg_front;
        regBack.parentNode.querySelector('img').src = "<?= site_url('Admin/Bikes/displayRegPhoto/') ?>" + json.reg_back;

        // Set all inputs to readonly (until 'edit' button is pressed)
        inputs.forEach(e => e.setAttribute('readonly', 'true'));

        // Hide plateNumber and viewProfile. Show selectNewProfile
        plateNumberDiv.classList.add('hidden');
        viewProfile.classList.add('hidden');
        selectNewProfile.classList.remove('hidden');
        editButton.classList.remove('hidden');
      }
    });
  });

  // Create consts for the UNIQUE individual page elements plus consts for the other elements taken as UNIQUE groups.
  // This is necessary so that we can set event listeners that will change the state of individual components while leaving
  // other, identical components unaffected.

  const photoBoxes = document.querySelectorAll('.photoBox'); // boxes for displaying/editing photos associated with record
  const photoCaptions = document.querySelectorAll('.photoCaption'); // captions for each photo
  const photoImages = document.querySelectorAll('.photoImage'); // the img elements in each photoBox
  const deleteButtons = document.querySelectorAll('.deleteButton'); // delete buttons for each photo
  const photoInputs = document.querySelectorAll('.photoInput'); // photo inputs remain hidden
  const selectPhotos = document.querySelectorAll('.selectPhoto'); // 'selectPhoto' buttons, which display during edit mode in photoBoxes which have no image

  // For each photoImage that loads set its photoBox's data-image attribute to "loaded" (default is "unloaded")
  photoImages.forEach(function(e) {
    e.addEventListener('load', function() {
      e.parentNode.dataset.image = "loaded";
    });
  });

  // Set another click event listener on the editButton to display deleteButtons for any photoBox whose img's classlist
  // doesn't currently contain 'hidden'
  editButton.addEventListener('click', function(event) {

    deleteButtons.forEach(function(e) {
      if (!(e.previousElementSibling.classList.contains('hidden'))) {
        e.classList.remove('hidden');
      }
    })
  });

  // // Set all elements to correct initial state when page loads
  window.onload = function() {

    plateNumber.value = "<?php
                          if (isset($plateNumber)) {
                            echo $plateNumber;
                          } else {
                            echo '';
                          }

                          ?>";

    // plateNumber.value = plateNumber;
    viewProfile.click();

    deleteButtons.forEach((e) => e.classList.add('hidden')); // hide the delete buttons
    photoInputs.forEach((e) => e.classList.add('hidden')); // hide each of the photo inputs
    photoImages.forEach((e) => e.classList.add('hidden')); // hide the img elements since they're empty
    // But have them display when an image has loaded
    photoImages.forEach((e) => e.addEventListener('load', function(event) {
      event.target.classList.remove('hidden');
    }));

  }

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


  // Have the delete button asynchronously call the deleteCustomerPhoto controller
  deleteButtons.forEach((e) => e.addEventListener('click', function(event) {

    const urlBaseReg = "<?= site_url('Admin/Bikes/deleteRegPhoto/') ?>";
    const urlBaseBike = "<?= site_url('Admin/Bikes/deleteBikePhoto/') ?>";
    let urlBase;

    // // So we can use this function with each photoBox we need to put together the correct url
    // // by using a regex to tease out the path name from the img's src attribute
    if (e.previousElementSibling.previousElementSibling.textContent.includes('Registration')) {
      urlBase = urlBaseReg;
    } else {
      urlBase = urlBaseBike;
    }

    let regEx = /(?<=o\/).*/i;
    let urlString = e.previousElementSibling.src;
    let result = regEx.exec(urlString);
    // const path = result[0];
    // const url = urlBase + path;

    // Call the controller method to delete the photo from server
    // if (path.length < 80) {
    //   fetch(url).catch((error) => console.log(error));
    // }

    // // And remove the image from page by setting src to empty string
    // event.target.previousElementSibling.src = '';

    // // Since there's currently nothing to delete, hide the button
    // event.target.classList.add('hidden');

    // // Remove any previously selected image from the file input so we don't upload it
    // const input = event.target.parentNode.querySelector('input');
    // input.value = '';

    // // Show our little selectPhoto tag and hide the empty img
    // const selectPhoto = event.target.parentNode.querySelector('.selectPhoto');
    // selectPhoto.classList.remove('hidden');
    // event.target.previousElementSibling.classList.add('hidden');

  }));


  // // This section of code provides some functionality for our mailForm.
  // // It fetches a JSON object with names and email addresses of current customers and adds an event listener to 
  // // a select element in the form so we can simply select the name of a customer and automatically have their
  // // email address added to the corresonding form input (for non-customers we can still manually enter the email address)

  // let emailJSON;
  // const mailForm = document.querySelector('.mailForm');
  // const url = "<?= site_url('Admin/Customers/emailsAsJSON'); ?>";
  // const email = document.querySelector('.email');
  // const nameInput = document.querySelector('#names');
  // const messageBox = document.querySelector('.messageBox');

  // window.addEventListener('load', function(e) {
  //   fetch(url).then((response) => response.json()).then(function(json) {
  //     emailJSON = json;
  //   });
  //   mailForm.classList.add('hidden');
  //   email.value = '';
  //   nameInput.selectedIndex = 0;
  //   messageBox.value = '';
  // });

  // nameInput.addEventListener('change', function(e) {
  //   const name = nameInput.value;
  //   email.value = emailJSON[name] ?? '';
  // });

  // // This section of code provides functionality for our selectButtons.
  // // Pressing a button will add the corresponding photo's path to an array and make the mailForm visible

  // let selected = [];
  // const selectButtons = document.querySelectorAll('.selectButton');
  // const deselectButtons = document.querySelectorAll('.deselectButton');

  // // Hide the deselectButtons on page load
  // window.addEventListener('load', function(e) {
  //   deselectButtons.forEach((button) => button.classList.add('hidden'));
  // });

  // // Hide both selectButtons and deselectButtons once editButton has been clicked
  // editButton.addEventListener('click', function(evt) {
  //   deselectButtons.forEach(el => el.classList.add('hidden'));
  //   selectButtons.forEach(el => el.classList.add('hidden'));
  // })

  // // Clicking selectButton will hide it and show the deselectButton. The selected image will be darkened and
  // // the mailForm will display. Finally, the corresponding photo's path will be added to selected[].
  // // If selected.length > 4 all selectButtons are hidden
  // selectButtons.forEach((button) => button.addEventListener('click', function(e) {
  //   mailForm.classList.remove('hidden');
  //   e.target.classList.add('hidden');
  //   e.target.nextElementSibling.classList.remove('hidden');
  //   e.target.parentNode.querySelector('img').style.filter = 'brightness(50%)';
  //   const path = e.target.parentNode.querySelector('img').src;
  //   const regEx = /(?<=o\/).*/i;
  //   const result = regEx.exec(path);
  //   selected.push(result[0]);

  //   if (selected.length > 4) {
  //     selectButtons.forEach((button) => button.classList.add('hidden'));
  //   }
  // }));

  // // Clicking deselectButton will hide it and show the selectButton. The selected image will have its normal
  // // brightness restored and the corresponding photo's path will be removed from selected[].
  // // The mailForm will be hidden if selected.length < 1.
  // // If selected.length < 5 any selectButtons whose sibling deleteButtons are hidden will be unhidden

  // deselectButtons.forEach((button) => button.addEventListener('click', function(e) {
  //   e.target.classList.add('hidden');
  //   e.target.previousElementSibling.classList.remove('hidden');
  //   e.target.parentNode.querySelector('img').style.filter = 'brightness(100%)';
  //   const path = e.target.parentNode.querySelector('img').src;
  //   const regEx = /(?<=o\/).*/i;
  //   const result = regEx.exec(path);

  //   selected = selected.filter(function(element) {
  //     return element !== result[0];
  //   });

  //   if (selected.length < 1) {
  //     mailForm.classList.add('hidden');
  //   }

  //   if (selected.length < 5) {
  //     selectButtons.forEach(function(e) {
  //       if (e.nextElementSibling.classList.contains('hidden')) {
  //         e.classList.remove('hidden');
  //       }
  //     })
  //   }

  // }));

  // // Create a const for our sendButton and give it a click event listener that will:
  // // put the email address, message, and paths of selected photos into a FormData object,
  // // send our FormData object as the body of an async POST request to the controller which actually mails everything,
  // // and finally return everything to its original state
  // const sendButton = document.querySelector('#sendButton');

  // sendButton.addEventListener('click', function(e) {
  //   const formData = new FormData();
  //   formData.append('address', email.value);
  //   // Add a default message if the messageBox is empty
  //   formData.append('message', ((messageBox.value == '') ? 'Thanks for choosing Saigon Bike Rentals!' : messageBox.value));

  //   for (let index = 0; index < selected.length; index++) {
  //     formData.append(('path' + (index + 1)), selected[index]);
  //   }

  //   if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value)) {
  //     fetch("<?= site_url('Admin/Bikes/mailRegPhotos') ?>", {
  //       method: 'POST',
  //       body: formData
  //     }).then(response => response.text().then(text => alert(text)).catch(error => console.log(error)));

  //     selected = [];
  //     selectButtons.forEach(e => e.classList.remove('hidden'));
  //     deselectButtons.forEach(e => e.classList.add('hidden'));
  //     email.value = '';
  //     messageBox.value = '';
  //     nameInput.selectedIndex = 0;
  //     mailForm.classList.add('hidden');
  //     photoImages.forEach(e => e.style.filter = 'brightness(100%)');
  //   } else {
  //     alert('Please enter a valid email address');
  //   }
  // });

  // // And lastly our cancelButton will do everything the sendButton does except the send part
  // const mailCancelButton = document.querySelector('#mailCancelButton');

  // mailCancelButton.addEventListener('click', function(e) {
  //   selected = [];
  //   selectButtons.forEach(e => e.classList.remove('hidden'));
  //   deselectButtons.forEach(e => e.classList.add('hidden'));
  //   email.value = '';
  //   messageBox.value = '';
  //   nameInput.selectedIndex = 0;
  //   mailForm.classList.add('hidden');
  //   photoImages.forEach(e => e.style.filter = 'brightness(100%)');

  // });
</script>

<?= $this->endSection() ?>