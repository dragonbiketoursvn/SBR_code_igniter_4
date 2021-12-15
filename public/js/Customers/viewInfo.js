// Create consts for the UNIQUE individual page elements plus consts for the other elements taken as UNIQUE groups.
// This is necessary so that we can set event listeners that will change the state of individual components while leaving
// other, identical components unaffected.

const edit = document.querySelector(".edit_button"); // the edit button
const update = document.querySelector("#update"); // the update button
const inputs = document.querySelectorAll("input"); // the form inputs
const showCustomerDetails = document.querySelector("#showCustomerDetails"); // the 'Show Customer Details' button
const customerInfo = document.querySelector(".customer_info"); // the input fields which are hidden before pressing 'Show Customer Details'
const showPayments = document.querySelector("#show_payments"); // the 'Show Payment History' button
const paymentHistory = document.querySelector(".payment_history"); // the div containing renter's payment history table
const photoBoxes = document.querySelectorAll(".photoBox"); // boxes for displaying/editing photos associated with record
const photoCaptions = document.querySelectorAll(".photoCaption"); // captions for each photo
const photoImages = document.querySelectorAll(".photoImage"); // the img elements in each photoBox
const deleteButtons = document.querySelectorAll(".deleteButton"); // delete buttons for each photo
const photoInputs = document.querySelectorAll(".photoInput"); // photo inputs are hidden until 'edit' button is pressed
const selectPhotos = document.querySelectorAll(".selectPhoto"); // 'selectPhoto' buttons, which display during edit mode in photoBoxes which have no image

// Fore each photoImage that loads set its photoBox's data-image attribute to "loaded" (default is "unloaded")
photoImages.forEach(function (e) {
  e.addEventListener("load", function () {
    e.parentNode.dataset.image = "loaded";
  });
});

// Set all elements to correct initial state when page loads
window.onload = function () {
  update.classList.add("hidden"); // hide the update button
  deleteButtons.forEach((e) => e.classList.add("hidden")); // hide the delete buttons
  edit.classList.add("hidden"); // hide the edit button
  customerInfo.classList.add("hidden"); // hide customer info fields
  paymentHistory.classList.add("hidden"); // hide payment history
  photoInputs.forEach((e) => e.classList.add("hidden")); // hide each of the photo inputs
  selectPhotos.forEach((e) => e.classList.add("hidden")); // hide the selectPhoto buttons
};

// When we click on the edit button, hide the edit button
// Display the update button and make all the inputs writable
// Also display the photo inputs OR MAYBE NOT BOTHER?
edit.addEventListener("click", function (e) {
  inputs.forEach(function (input) {
    input.removeAttribute("readonly");
  });

  edit.classList.add("hidden");
  update.classList.remove("hidden");
  // photoInputs.forEach((e) => e.classList.remove('hidden'));
});

// Add another click event listener on the edit button to check if each photoBox div has child img element or not
// If an img has loaded, we display the delete button for that photoBox
// If not, we display selectPhoto and hide the photoImage img for that photoBox
edit.addEventListener("click", function () {
  photoBoxes.forEach(function (e) {
    if (e.dataset.image == "loaded") {
      const deleteButton = e.querySelector(".deleteButton"); // Create a const to hold deleteButton for this photoBox
      deleteButton.classList.remove("hidden"); // Display the deleteButton
    } else {
      const selectPhoto = e.querySelector(".selectPhoto"); // Create a const to hold selectPhoto button for this photobox
      const photoImage = e.querySelector(".photoImage"); // Create a const to hold selectPhoto button for this photobox
      selectPhoto.classList.remove("hidden"); // Display the selectPhoto button
      photoImage.classList.add("hidden"); // Hide the photoImage img element since it's empty
    }
  });
});

// Show customer info when user clicks on Show Customer Details (and remove the Show Customer Details button)
showCustomerDetails.addEventListener("click", function (e) {
  edit.classList.remove("hidden");
  customerInfo.classList.remove("hidden");
  e.target.classList.add("hidden");
});

// Do the same for payment history
showPayments.addEventListener("click", function (e) {
  paymentHistory.classList.remove("hidden");
  e.target.classList.add("hidden");
});

// Have the delete button asynchronously call the deleteCustomerPhoto controller
deleteButtons.forEach((e) =>
  e.addEventListener("click", function (e) {
    // So we can use this function with each photoBox we need to put together the correct url
    // by using a regex to tease out the path name from the img's src attribute
    const urlBase = "<?= site_url('Admin/Customers/deleteCustomerPhoto/')?>";

    let regEx = /(?<=o\/).*/i;
    let urlString = e.target.previousElementSibling.src;
    console.log(urlString);
    let result = regEx.exec(urlString);
    const path = result[0];
    const url = urlBase + path;

    // Call the controller method to delete the photo from server
    if (path.length < 80) {
      fetch(url).catch((error) => console.log(error));
    }

    // And remove the image from page by setting src to empty string
    e.target.previousElementSibling.src = "";

    // Since there's currently nothing to delete, hide the button
    e.target.classList.add("hidden");

    // Remove any previously selected image from the file input so we don't upload it
    input = e.target.parentNode.querySelector("input");
    input.value = "";

    // Show our little selectPhoto tag and hide the empty img
    const selectPhoto = e.target.parentNode.querySelector(".selectPhoto");
    selectPhoto.classList.remove("hidden");
    e.target.previousElementSibling.classList.add("hidden");
  })
);

// Once we've successfully selected a file the change event fires and our callback is invoked
photoInputs.forEach((e) =>
  e.addEventListener("change", function (event) {
    // Set constants for the photoInput's parent photoBox and its sibling photoImage, deleteButon, and selectPhoto
    const photoBox = event.target.parentNode;
    const photoImage = photoBox.querySelector(".photoImage");
    const deleteButton = photoBox.querySelector(".deleteButton");
    const selectPhoto = photoBox.querySelector(".selectPhoto");

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
      photoImage.classList.remove("hidden");
      deleteButton.classList.remove("hidden");
      selectPhoto.classList.add("hidden");
    };
  })
);
