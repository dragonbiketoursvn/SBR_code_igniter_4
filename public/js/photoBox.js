// for photoBoxes
const photoBoxes = document.querySelectorAll(".photo-box");

// for the mailForm
const mailForms = document.querySelectorAll(".mailForm");
let selected = [];

/* Initialize our photoBoxes */
photoBoxes.forEach((el) => {
  // Create consts for the components to be shown or hidden initially
  const photoImage = el.querySelector(".photo-image");
  const placeHolder = el.querySelector(".place-holder");
  //   const selectPhoto = el.querySelector(".select-photo");
  const selectPhoto = el.querySelector(".select-photo-wrapper");
  const photoInput = el.querySelector(".photo-input");
  const deleteButton = el.querySelector(".delete-button");
  const removeButton = el.querySelector(".remove-button");
  const selectButton = el.querySelector(".select-button");
  const deselectButton = el.querySelector(".deselect-button");

  // all the buttons and the photoImages are hidden initially
  deleteButton.classList.add("hidden");
  removeButton.classList.add("hidden");
  selectButton.classList.add("hidden");
  deselectButton.classList.add("hidden");
  photoImage.classList.add("hidden");
  selectPhoto.classList.add("hidden");

  // hide the photoInput as well and add event listener to display preview image
  photoInput.classList.add("hidden");
  photoInput.addEventListener("change", function (evt) {
    // Assign file selected by input (via the input's files attribute) to const file
    const file = evt.target.files[0];

    // Exit if no file was selected
    if (!file) return;

    // Create a FileReader object
    const reader = new FileReader();

    // Read file into reader as DataURL
    reader.readAsDataURL(file);

    // Once read operation has successfully finished, set photoImage's src attribute to the value of the reader's
    // result property (in this case a DataURL)
    // Then unhide photoImage and deletButton and hide selectPhoto
    reader.onload = function (evt) {
      photoImage.src = evt.target.result;
      photoImage.classList.remove("hidden");
      selectPhoto.classList.add("hidden");

      // set the photoBox's data-image attribute to 'loaded'
      el.dataset.image = "loaded";

      // Show removeButton if photoBox has new-record class applied, otherwise show deleteButton
      if (photoImage.parentNode.classList.contains("new-record")) {
        removeButton.classList.remove("hidden");
      } else {
        deleteButton.classList.remove("hidden");
      }
    };
  });

  // hide everything we don't need for an empty 'new-record' photoBox
  if (el.classList.contains("new-record")) {
    placeHolder.classList.add("hidden");
    deleteButton.classList.add("hidden");
    removeButton.classList.add("hidden");
    selectButton.classList.add("hidden");
    selectPhoto.classList.remove("hidden");
  } else {
    // we won't see selectPhoto unless the edit button is pressed
    // selectPhoto.classList.add("hidden");

    // if it's not a 'new-record' we need to check whether a photo has loaded and if so, hide placeholder and show photoImage
    // if 'can-send' class is applied we show the selectButton, otherwise not.
    photoImage.addEventListener("load", function (evt) {
      // set the photoBox's data-image attribute to 'loaded'
      el.dataset.image = "loaded";

      placeHolder.classList.add("hidden");
      photoImage.classList.remove("hidden");

      if (
        !el.classList.contains("new-record") &&
        el.dataset.editMode !== "on"
      ) {
        selectButton.classList.remove("hidden");
      }
    });
  }

  /* || removeButton */
  // clicking the removeButton removes the preview img and attached file, re-displays selectPhoto, and hides itself
  removeButton.addEventListener("click", function (evt) {
    removeButton.parentNode.dataset.image = "unloaded";
    photoImage.src = "";
    photoInput.value = "";
    selectPhoto.classList.remove("hidden");
    removeButton.classList.add("hidden");
    photoImage.classList.add("hidden");
  });

  /* || selectButton */
  // Clicking selectButton will hide it and show the deselectButton. The selected image will be darkened and
  // the mailForm will display. Finally, the corresponding photo's path will be added to selected[].
  // If selected.length > 4 all selectButtons are hidden
  selectButton.addEventListener("click", function (evt) {
    selectButton.classList.add("hidden");
    deselectButton.classList.remove("hidden");
    mailForms.forEach((mailForm) => mailForm.classList.remove("hidden"));

    photoImage.style.filter = "brightness(50%)";
    const path = photoImage.src;
    const regEx = /(?<=o\/).*/i;
    const result = regEx.exec(path);
    selected.push(result[0]);

    if (selected.length > 4) {
      // hide all the selectButtons on the page
      const selectButtons = document.querySelectorAll(".select-button");
      selectButtons.forEach((button) => button.classList.add("hidden"));
    }
  });

  /* || deselectButton */
  // Clicking deselectButton will hide it and redisplay the selectButton. The selected image will have its normal
  // brightness restored and the corresponding photo's path will be removed from selected[].
  // The mailForm will be hidden if selected.length < 1.
  // If selected.length < 5 any selectButtons whose sibling deselectButtons are hidden will be unhidden
  deselectButton.addEventListener("click", function (evt) {
    const path = photoImage.src;
    const regEx = /(?<=o\/).*/i;
    const result = regEx.exec(path);

    selected = selected.filter(function (element) {
      return element !== result[0];
    });

    if (selected.length < 1) {
      mailForms.forEach((mailForm) => mailForm.classList.add("hidden"));
    }

    if (selected.length < 5) {
      // re-display selectButtons only for unselected images in photoBoxes of class 'can-send'
      const selectButtons = document.querySelectorAll(".select-button");

      selectButtons.forEach(function (selectButtonElement) {
        if (
          selectButtonElement.parentNode.classList.contains("can-send") &&
          selectButtonElement.nextElementSibling.classList.contains("hidden")
        ) {
          selectButtonElement.classList.remove("hidden");
        }
      });
    }

    deselectButton.classList.add("hidden");
    selectButton.classList.remove("hidden");
    photoImage.style.filter = "brightness(100%)";
  });

  /* || deleteButton */
  // clicking the deleteButton will delete the current photoBox's photoInput from the server (if it exists) and remove it
  // from the display, and also set the photoBox's data-image property to unloaded
  deleteButton.addEventListener("click", (evt) => {
    const urlBase =
      "http://sbr_code_igniter_4.localhost/Admin/Photos/deletePhoto/";
    let regEx = /(?<=o\/).*/i;
    let urlString = photoImage.src;
    let result = regEx.exec(urlString);
    const path = result[0];
    const url = urlBase + path;

    // Call the controller method to delete the photo from server
    if (path.length < 80) {
      fetch(url).catch((error) => console.log(error));
    }

    // And remove the image from page by setting src to empty string
    photoImage.src = "";

    // Since there's currently nothing to delete, hide the button
    deleteButton.classList.add("hidden");

    // Remove any previously selected image from the photoInput so we don't upload it
    photoInput.value = "";

    // Show our little selectPhoto tag and hide the empty img
    selectPhoto.classList.remove("hidden");
    photoImage.classList.add("hidden");

    // and set the photoBox's data-image property to unloaded
    deleteButton.parentNode.dataset.image = "unloaded";
  });
});

/* Initialize our mailForms*/
mailForms.forEach(function (mailForm) {
  // Set local constants to grab all the select/deselectButtons on the screen
  const selectButtons = document.querySelectorAll(".select-button");
  const deselectButtons = document.querySelectorAll(".deselect-button");

  // Set local constants for the internal components plus stuff for fetching email addresses as json
  let mailFormEmailAddressesJSON;
  const mailFormGetEmailAddressesURL =
    "http://sbr_code_igniter_4.localhost/Admin/Customers/emailsAsJSON";
  const mailFormEmailInput = mailForm.querySelector(".mailForm-email-input");
  const mailFormNameInput = mailForm.querySelector("#mailForm-name-input");
  const mailFormMessageBox = mailForm.querySelector(".mailForm-messageBox");
  const mailFormSendButton = mailForm.querySelector("#mailForm-sendButton");
  const mailFormCancelButton = mailForm.querySelector("#mailForm-cancelButton");

  // fetch the email addresses
  fetch(mailFormGetEmailAddressesURL)
    .then((response) => response.json())
    .then(function (json) {
      mailFormEmailAddressesJSON = json;
    });

  // hide the mailForm and unset all inputs
  mailForm.classList.add("hidden");
  mailFormEmailInput.value = "";
  mailFormNameInput.selectedIndex = 0;
  mailFormMessageBox.value = "";

  mailFormNameInput.addEventListener("change", function (evt) {
    const name = mailFormNameInput.value;
    mailFormEmailInput.value = mailFormEmailAddressesJSON[name] ?? "";
  });

  // give mailFormSendButton a click event listener that will:
  // put the email address, message, and paths of selected photos into a FormData object,
  // send our FormData object as the body of an async POST request to the controller which actually mails everything,
  // and finally return everything to its original state
  mailFormSendButton.addEventListener("click", function (evt) {
    const formData = new FormData();
    formData.append("address", mailFormEmailInput.value);

    // Add a default message if the messageBox is empty
    formData.append(
      "message",
      mailFormMessageBox.value == ""
        ? "Thanks for choosing Saigon Bike Rentals!"
        : mailFormMessageBox.value
    );

    for (let index = 0; index < selected.length; index++) {
      formData.append("path" + (index + 1), selected[index]);
    }

    if (
      /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(
        mailFormEmailInput.value
      )
    ) {
      fetch("http://sbr_code_igniter_4.localhost/Admin/Photos/mailPhotos", {
        method: "POST",
        body: formData,
      }).then((response) =>
        response
          .text()
          .then((text) => alert(text))
          .catch((error) => console.log(error))
      );

      selected = [];
      document.querySelectorAll(".select-button").forEach(function (el) {
        if (el.parentNode.dataset.image === "loaded") {
          el.classList.remove("hidden");
        }
      });
      document
        .querySelectorAll(".deselect-button")
        .forEach((el) => el.classList.add("hidden"));
      mailFormEmailInput.value = "";
      mailFormMessageBox.value = "";
      mailFormNameInput.selectedIndex = 0;
      mailForm.classList.add("hidden");
      document
        .querySelectorAll(".photo-image")
        .forEach((el) => (el.style.filter = "brightness(100%)"));
    } else {
      alert("Please enter a valid email address");
    }
  });

  // And lastly our mailFormCancelButton will do everything the sendButton does except the send part
  mailFormCancelButton.addEventListener("click", function (evt) {
    selected = [];
    selectButtons.forEach(function (el) {
      if (
        el.parentNode.dataset.image === "loaded" &&
        !el.parentNode.classList.contains("new-record")
      ) {
        el.classList.remove("hidden");
      }
    });

    document
      .querySelectorAll(".deselect-button")
      .forEach((el) => el.classList.add("hidden"));
    mailFormEmailInput.value = "";
    mailFormMessageBox.value = "";
    mailFormNameInput.selectedIndex = 0;
    mailForm.classList.add("hidden");

    // grab all the photoImage elements on the page and switch back to normal brightness
    const photoImages = document.querySelectorAll(".photo-image");
    photoImages.forEach((el) => (el.style.filter = "brightness(100%)"));

    // and redisplay the selectButtons
  });
});
