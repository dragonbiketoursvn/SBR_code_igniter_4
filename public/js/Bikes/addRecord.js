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
    e.addEventListener('load', function () {
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
reader.onload = function (event) {

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

    foreach($currentBikes as $currentBike) {
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