// || VARIABLES SECTION

// || global variables
let currentDate;
let currentRenters;
let currentRentersWithPaymentHistory;
let currentRenter = {};
let allRentersEver;
let currentRenterNameList = [];
let currentBikes;
let bikeDataList = [];
let nationalitiesDataList = [];
let paymentHistory;
let bikeIn = {};
let bikeOut = {};
let renterIncidents = [];

const baseURL = "http://sbr_code_igniter_4.localhost/Admin/Customers/";
const currentUser = document.querySelector("body").getAttribute("data-user");
let filterColumn = null; // we use this to track the column being filtered in results tables
let filterColumnType = null; // we need to know whether the column holds numerical values in order to sort them correctly

// || view section variables
const initialView = document.querySelector("#initial-view");
const interactionView = document.querySelector("#interaction-view");
const newContractView = document.querySelector("#new-contract-view");
const profilesView = document.querySelector("#profiles-view");
const incidentView = document.querySelector("#incident-view");
const messageView = document.querySelector("#message-view");

// || inital-view variables
const startInteractionButton = initialView.querySelector("#start-interaction");
const newContractButton = initialView.querySelector("#new-contract");
const profilesButton = initialView.querySelector("#profiles"); //Remember to check whether null
const incidentsButton = initialView.querySelector("#incidents"); //Remember to check whether null
const sendMessageButton = initialView.querySelector("#send-message"); //Remember to check whether null

// || interaction-view variables
// view-level variables
const interactionViewInputs = interactionView.querySelectorAll(
  'input:not([type="hidden"])'
);

// state1 variables
const interactionViewState1 = interactionView.querySelector(
  "#interaction-view-state-1"
);
const interactionViewRenterSelectInput = interactionView.querySelector(
  "#interaction-view-renter-select-input"
);
const interactionViewRentersList = interactionView.querySelector(
  "#interaction-view-renters-list"
);
const interactionViewStartProcessButton = interactionView.querySelector(
  "#interaction-view-start-process-button"
);
const interactionViewCancelButton = interactionView.querySelector(
  "#interaction-view-cancel-button"
);

// state2 variables
const interactionViewState2 = interactionView.querySelector(
  "#interaction-view-state-2"
);
const customerIsPayingButton = interactionView.querySelector(
  "#customer-is-paying-button"
);
const customerNotPayingButton = interactionView.querySelector(
  "#customer-not-paying-button"
);

// state 2a variables
const interactionViewState2a = interactionView.querySelector(
  "#interaction-view-state-2a"
);
const paymentForm = interactionView.querySelector("#payment-form");
const paymentFormUserInput = interactionView.querySelector(
  "#payment-form-user-input"
);
const paymentFormCustomerIdInput = interactionView.querySelector(
  "#payment-form-customer-id-input"
);
const paymentFormNameInput = interactionView.querySelector(
  "#payment-form-name-input"
);
const paymentFormAmountInput = interactionView.querySelector(
  "#payment-form-amount-input"
);
const paymentFormMonthsInput = interactionView.querySelector(
  "#payment-form-months-input"
);
const paymentFormDateInput = interactionView.querySelector(
  "#payment-form-date-input"
);
const radioButtons = interactionView.querySelectorAll('input[type="radio"]');
const paymentFormNotesInput = interactionView.querySelector(
  "#payment-form-notes-input"
);
const paymentFormSubmitButton = interactionView.querySelector(
  "#payment-form-submit-button"
);
const paymentFormCancelButton = interactionView.querySelector(
  "#payment-form-cancel-button"
);
// state3 variables
const interactionViewState3 = interactionView.querySelector(
  "#interaction-view-state-3"
);
const customerIsExchangingButton = interactionView.querySelector(
  "#customer-is-exchanging-button"
);
const customerNotExchangingButton = interactionView.querySelector(
  "#customer-not-exchanging-button"
);
// state3a variables
const interactionViewState3a = interactionView.querySelector(
  "#interaction-view-state-3a"
);
const exchangeFormBikeInInput = interactionView.querySelector(
  "#exchange-form-bike-in-input"
);
const exchangeFormBikeOutInput = interactionView.querySelector(
  "#exchange-form-bike-out-input"
);
const interactionViewBikeList = interactionView.querySelector(
  "#interaction-view-bike-list"
);
const exchangeFormSubmitButton = interactionView.querySelector(
  "#exchange-form-submit-button"
);
const exchangeFormCancelButton = interactionView.querySelector(
  "#exchange-form-cancel-button"
);

// state3b variables
const interactionViewState3b = interactionView.querySelector(
  "#interaction-view-state-3b"
);
const openRepairAndReturnTicketButton = interactionView.querySelector(
  "#open-repair-and-return-ticket-button"
);
const closeRepairAndReturnTicketButton = interactionView.querySelector(
  "#close-repair-and-return-ticket-button"
);

// state4 variables
const interactionViewState4 = interactionView.querySelector(
  "#interaction-view-state-4"
);
const customerInteractionNotesInput = interactionView.querySelector(
  "#customer-interaction-notes-input"
);
const submitCustomerInteractionNoteButton = interactionView.querySelector(
  "#submit-customer-interaction-note-button"
);

// || new-contract-view variables
const newContractViewInputs = newContractView.querySelectorAll(
  'input:not([type="hidden"])'
);
const newContractForm = newContractView.querySelector("#new-contract-form");
const contractFirstNameInput = newContractView.querySelector(
  "#contract-first-name-input"
);
const contractSurnameInput = newContractView.querySelector(
  "#contract-surname-input"
);
const contractCustomerNameInput = newContractView.querySelector(
  "#contract-customer-name-input"
);
const contractStartDateInput = newContractView.querySelector(
  "#contract-start-date-input"
);
const contractNationalityInput = newContractView.querySelector(
  "#contract-nationality-input"
);
const contractEmailInput = newContractView.querySelector(
  "#contract-email-input"
);
const contractPhoneNumberInput = newContractView.querySelector(
  "#contract-phone-number-input"
);
const contractCurrentBikeInput = newContractView.querySelector(
  "#contract-current-bike-input"
);
const contractModelInput = newContractView.querySelector(
  "#contract-model-input"
);
const contractDepositTypeInput = newContractView.querySelector(
  "#contract-deposit-type-input"
);
const contractRentInput = newContractView.querySelector("#contract-rent-input");
const contractNotesInput = newContractView.querySelector(
  "#contract-notes-input"
);
const contractBuildingNameInput = newContractView.querySelector(
  "#contract-building-name-input"
);
const contractStreetNameInput = newContractView.querySelector(
  "#contract-street-name-input"
);
const contractWardInput = newContractView.querySelector("#contract-ward-input");
const contractDistrictInput = newContractView.querySelector(
  "#contract-district-input"
);
const contractPassportInput = newContractView.querySelector(
  "#contract-passport-input"
);
const contractTRCOrVisaInput = newContractView.querySelector(
  "#contract-TRC-or-visa-input"
);
const contractLicenseFrontInput = newContractView.querySelector(
  "#contract-license-front-input"
);
const contractLicenseBackInput = newContractView.querySelector(
  "#contract-license-back-input"
);
const contractPlateNumbersList = newContractView.querySelector(
  "#contract-plate-numbers-list"
);
const contractNationalitiesList = newContractView.querySelector(
  "#contract-nationalities-list"
);
const contractSubmitButton = newContractView.querySelector(
  "#contract-submit-button"
);
const contractCancelButton = newContractView.querySelector(
  "#contract-cancel-button"
);

// || profiles-view variables
const profilesViewInputs = profilesView.querySelectorAll(
  'input:not([type="hidden"])'
);
const profilesViewDesktopState1 = profilesView.querySelector(
  "#profiles-view-desktop-state-1"
);
const profilesViewCurrentRentersButton = profilesView.querySelector(
  "#profiles-view-current-renters-button"
);
const profilesViewAllRentersButton = profilesView.querySelector(
  "#profiles-view-all-renters-button"
);
const profilesViewBackButton = profilesView.querySelector(
  "#profiles-view-back-button"
);
const profilesViewMobileState1 = profilesView.querySelector(
  "#profiles-view-mobile-state-1"
);
const profilesViewNameInput = profilesView.querySelector(
  "#profiles-view-name-input"
);
const profilesViewMobileGetProfileButton = profilesView.querySelector(
  "#profiles-view-mobile-get-profile-button"
);
const profilesViewMobileBackButton = profilesView.querySelector(
  "#profiles-view-mobile-back-button"
);
const profilesViewDesktopState2 = profilesView.querySelector(
  "#profiles-view-desktop-state-2"
);
const profilesViewRenterTable = profilesView.querySelector(
  "#profiles-view-renter-table"
);
// const profilesViewRenterTableBody = profilesView.querySelector(
//   "#profiles-view-renter-table-body"
// );

// state2a variables
const profilesViewDesktopState2a = profilesView.querySelector(
  "#profiles-view-desktop-state-2a"
);
const profilesViewAllRenterTable = profilesView.querySelector(
  "#profiles-view-all-renter-table"
);
const profilesViewFilterButtons = profilesView.querySelectorAll(
  ".profiles-view-filter-button"
);
const profilesViewCurrentFilterWindow = profilesView.querySelector(
  "#profiles-view-current-filter-window"
);
const profilesViewCurrentFilterInputs = profilesView.querySelector(
  "#profiles-view-current-filter-inputs"
);
const profilesViewCurrentApplyFilterButton = profilesView.querySelector(
  "#profiles-view-current-apply-filter-button"
);
const profilesViewCurrentCancelFilterButton = profilesView.querySelector(
  "#profiles-view-current-cancel-filter-button"
);
const profilesViewRemoveFiltersButton = profilesView.querySelector(
  "#profiles-view-remove-filters-button"
);
const profilesViewSortAscendingButton = profilesView.querySelector(
  "#profiles-view-sort-ascending-button"
);
const profilesViewSortDescendingButton = profilesView.querySelector(
  "#profiles-view-sort-descending-button"
);
const profilesViewTableBackButton = profilesView.querySelector(
  "#profiles-view-table-back-button"
);

// state3 variables
const profilesViewState3 = profilesView.querySelector("#profiles-view-state-3");

// renter details variables
const renterDetailsTab = profilesView.querySelector(
  "#individual-profile-renter-details"
);
const paymentHistoryTab = profilesView.querySelector(
  "#individual-profile-payment-history"
);
const individualProfile = profilesView.querySelector("#individual-profile");
const renterDetailsSection = profilesView.querySelector(
  "#renter-details-section"
);
const renterUpdateForm = profilesView.querySelector("#renter-update-form");
const renterUpdateCustomerIdInput = profilesView.querySelector(
  "#renter-update-customer-id-input"
);
const renterUpdateCustomerNameInput = profilesView.querySelector(
  "#renter-update-customer-name-input"
);
const renterUpdateStartDateInput = profilesView.querySelector(
  "#renter-update-start-date-input"
);
const renterUpdateNationalityInput = profilesView.querySelector(
  "#renter-update-nationality-input"
);
const renterUpdateNationalitiesList = profilesView.querySelector(
  "#renter-update-nationalities-list"
);
const renterUpdateEmailInput = profilesView.querySelector(
  "#renter-update-email-input"
);
const renterUpdatePhoneNumberInput = profilesView.querySelector(
  "#renter-update-phone-number-input"
);
const renterUpdateCurrentBikeInput = profilesView.querySelector(
  "#renter-update-current-bike-input"
);
const renterUpdatePlateNumberList = profilesView.querySelector(
  "#renter-update-plate-number-list"
);
const renterUpdateModelInput = profilesView.querySelector(
  "#renter-update-model-input"
);
const renterUpdateDepositTypeInput = profilesView.querySelector(
  "#renter-update-deposit-type-input"
);
const renterUpdateRentInput = profilesView.querySelector(
  "#renter-update-rent-input"
);
const renterUpdateNotesInput = profilesView.querySelector(
  "#renter-update-notes-input"
);
const renterUpdateBuildingNameInput = profilesView.querySelector(
  "#renter-update-building-name-input"
);
const renterUpdatBuildingNumberInput = profilesView.querySelector(
  "#renter-update-building-number-input"
);
const renterUpdateStreetNameInput = profilesView.querySelector(
  "#renter-update-street-name-input"
);
const renterUpdateWardInput = profilesView.querySelector(
  "#renter-update-ward-input"
);
const renterUpdateDistrictInput = profilesView.querySelector(
  "#renter-update-district-input"
);
const renterUpdatePassportInput = profilesView.querySelector(
  "#renter-update-passport-input"
);
const passportImage = profilesView.querySelector("#passport-image");
const visaImage = profilesView.querySelector("#visa-image");
const licenseFrontImage = profilesView.querySelector("#license-front-image");
const licenseBackImage = profilesView.querySelector("#license-back-image");

const renterUpdateTRCOrVisaInput = profilesView.querySelector(
  "#renter-update-TRC-or-visa-input"
);
const renterUpdateLicenseFrontInput = profilesView.querySelector(
  "#renter-update-license-front-input"
);
const renterUpdateLicenseBackInput = profilesView.querySelector(
  "#renter-update-license-back-input"
);
const renterUpdateEditButton = profilesView.querySelector(
  "#renter-update-edit-button"
);
const renterUpdateSubmitButton = profilesView.querySelector(
  "#renter-update-submit-button"
);

// payment history details
const paymentHistorySection = profilesView.querySelector(
  "#payment-history-section"
);
const paymentHistoryTable = profilesView.querySelector(
  "#payment-history-table"
);
const paymentHistoryCustomerInfo = profilesView.querySelector(
  "#payment-history-customer-info"
);

const individualProfileBackButton = profilesView.querySelector(
  "#individual-profile-back-button"
);

// || incident-view variables
// initial state
const createIncidentRecordButton = incidentView.querySelector(
  "#create-incident-record-button"
);
const viewIncidentRecordButton = incidentView.querySelector(
  "#view-incident-record-button"
);
const incidentViewBackButton = incidentView.querySelector(
  "#incident-view-back-button"
);

// state1
const incidentViewState1 = incidentView.querySelector("#incident-view-state-1");

// state2
const incidentViewState2 = incidentView.querySelector("#incident-view-state-2");
const newIncidentForm = incidentView.querySelector("#new-incident-form");
const incidentFormCustomerNameInput = incidentView.querySelector(
  "#incident-form-customer-name-input"
);
const incidentFormRenterList = incidentView.querySelector(
  "#incident-form-renter-list"
);
const incidentFormCustomerIdInput = incidentView.querySelector(
  "#incident-form-customer-id-input"
);
const incidentFormPlateNumberList = incidentView.querySelector(
  "#incident-form-plate-number-list"
);
const incidentFormSubmitButton = incidentView.querySelector(
  "#incident-form-submit-button"
);
const incidentFormCancelButton = incidentView.querySelector(
  "#incident-form-cancel-button"
);

// state3
const incidentViewState3 = incidentView.querySelector("#incident-view-state-3");
const incidentViewRecordTable = incidentView.querySelector(
  "#incident-view-record-table"
);
const incidentViewFilterButtons = incidentView.querySelectorAll(
  ".incident-view-filter-button"
);
const incidentViewRemoveFiltersButton = incidentView.querySelector(
  "#incident-view-remove-filters-button"
);
const incidentViewCurrentFilterWindow = incidentView.querySelector(
  "#incident-view-current-filter-window"
);
const incidentViewCurrentFilterInputs = incidentView.querySelector(
  "#incident-view-current-filter-inputs"
);
const incidentViewCurrentApplyFilterButton = incidentView.querySelector(
  "#incident-view-current-apply-filter-button"
);
const incidentViewCurrentCancelFilterButton = incidentView.querySelector(
  "#incident-view-current-cancel-filter-button"
);
const incidentViewSortAscendingButton = incidentView.querySelector(
  "#incident-view-sort-ascending-button"
);
const incidentViewSortDescendingButton = incidentView.querySelector(
  "#incident-view-sort-descending-button"
);
const incidentViewTableBackButton = incidentView.querySelector(
  "#incident-view-table-back-button"
);
const incidentViewPlateList = incidentView.querySelector(
  "#incident-view-plate-list"
);

// || message-view variables
const mailForm = messageView.querySelector("#mail-form");
const selectCustomerDiv = messageView.querySelector("#select-customer");
const mailFormNameList = messageView.querySelector("#name-list");
const namesInput = messageView.querySelector("#names");
const messageSubject = messageView.querySelector("#message-subject");
const messageBody = messageView.querySelector("#message-body");
const mailFormButtons = messageView.querySelector("#mail-form-buttons");
const mailFormSendMessageButton = messageView.querySelector(
  "#send-message-button"
);
const cancelMessageButton = messageView.querySelector("#cancel-message-button");

// || page initalization
// hide all views except inital view on page load and wait until renter and bike data is available
// before adding event listeners to the relevant buttons
window.addEventListener("load", function () {
  interactionView.classList.add("hidden");
  newContractView.classList.add("hidden");
  profilesView.classList.add("hidden");
  incidentView.classList.add("hidden");
  messageView.classList.add("hidden");

  // get the date in 'YYYY-MM-DD' format since it's such a fuckin hassle to do it via JavaScript
  fetch(baseURL + "getDate")
    .then((response) => response.json())
    .then((json) => {
      currentDate = json.date;
    });

  // asynchronously fetch current renter names, current plate numbers, and nationality list
  // and only add click event listeners to buttons once we have this data
  fetch(baseURL + "getRenters")
    .then((response) => response.json())
    .then((json) => {
      currentRenters = json;
      currentRenterNameList = [];
      for (renter of currentRenters) {
        currentRenterNameList.push(renter.customer_name);
      }
      currentRenterNameList.sort();
      console.log(currentRenters);
      return fetch(baseURL + "getBikes");
    })
    .then((response) => response.json())
    .then((json) => {
      currentBikes = json;
      for (bike of currentBikes) {
        bikeDataList.push(bike.plate_number);
      }
      console.log(currentBikes);
      console.log(bikeDataList);
      return fetch(baseURL + "getNationalities");
    })
    .then((response) => response.json())
    .then((json) => {
      for (x in json) {
        nationalitiesDataList.push(json[x].nationality);
      }
      // create a Set and convert back to array to get only unique values
      let tempSet = new Set(nationalitiesDataList);
      nationalitiesDataList = [...tempSet];
      nationalitiesDataList.sort();
    })
    .then(() => {
      startInteractionButton.addEventListener("click", () => {
        hideInitialView();
        openInteractionView();

        // clear the datalist
        interactionViewRentersList.innerHTML = "";

        currentRenterNameList.forEach((el) => {
          let option = document.createElement("option");
          option.value = el;
          interactionViewRentersList.appendChild(option);
        });
        interactionViewRenterSelectInput.focus();
      });

      newContractButton.addEventListener("click", () => {
        bikeDataList.forEach((el) => {
          let option = document.createElement("option");
          option.value = el;
          contractPlateNumbersList.appendChild(option);
        });

        nationalitiesDataList.forEach((el) => {
          let option = document.createElement("option");
          option.value = el;
          contractNationalitiesList.appendChild(option);
        });

        newContractViewInputs.forEach((el) => {
          el.value = "";
        });

        hideInitialView();
        openNewContractView();
        contractFirstNameInput.focus();
      });
    });

  if (profilesButton) {
    profilesButton.addEventListener("click", () => {
      hideInitialView();
      openProfilesView();

      // get all renter records (just in case) and once they've downloaded add event listener to viewAllRentersButton
      fetch(baseURL + "getAllRentersAsync")
        .then((response) => response.json())
        .then((json) => {
          allRentersEver = json;
          console.log(allRentersEver);
        })
        .then(() => {
          profilesViewAllRentersButton.addEventListener("click", () => {
            // profilesViewCurrentFilterWindow.classList.add("hidden");
            profilesViewCurrentFilterWindow.style.display = "none";
            populateRenterTable(allRentersEver);
            profilesViewDesktopState1.classList.add("hidden");
            profilesViewDesktopState2.classList.remove("hidden");
          });
        });
    });
  }

  if (incidentsButton) {
    incidentsButton.addEventListener("click", () => {
      hideInitialView();
      openIncidentsView();
    });
  }

  if (sendMessageButton) {
    sendMessageButton.addEventListener("click", () => {
      initialView.classList.add("hidden");
      currentRenters.forEach((renter) => {
        let option = this.document.createElement("option");
        option.value = renter.customer_name;
        mailFormNameList.appendChild(option);
      });
      // rememeber to clear the inputs!
      messageView.querySelectorAll("input").forEach((input) => {
        input.value = "";
      });
      messageView.classList.remove("hidden");
    });
  }
});

// || FUNCTIONS SECTION

// || global functions

// this updates currentRenters any time a record has been created or updated in the db
// record will be present as json
function updateCurrentRenters(json) {
  let renterSet = new Set(currentRenters);
  renterSet.forEach((renter) => {
    if (renter.id === json.customer.id) {
      renterSet.delete(renter);
      console.log("deleted!");
    }
  });
  renterSet.add(json.customer);
  currentRenters = [...renterSet];
  currentRenters.sort((a, b) => a.id - b.id);
}

// || inital-view functions
function hideInitialView() {
  initialView.classList.add("hidden");
}

function hideInitialView() {
  initialView.classList.add("hidden");
}

function openInteractionView() {
  //all states except state1 are hidden initally and state1 input value is empty
  let states = interactionView.querySelectorAll("div[id*=state]");
  states.forEach((el) => el.classList.add("hidden"));
  interactionViewInputs.forEach((el) => {
    el.value = "";
  });
  // interactionViewRenterSelectInput.value = "";
  interactionViewState1.classList.remove("hidden");
  interactionView.classList.remove("hidden");
}

function openNewContractView() {
  newContractView.classList.remove("hidden");
}

function openProfilesView() {
  //all states except state1 are hidden initally and state1 input value is empty
  let states = profilesView.querySelectorAll("div[id*=state]");
  states.forEach((el) => el.classList.add("hidden"));
  profilesViewInputs.forEach((el) => {
    el.value = "";
  });

  profilesView.classList.remove("hidden");

  if (screen.width > 800) {
    profilesViewDesktopState1.classList.remove("hidden");
  } else {
    profilesViewMobileState1.classList.remove("hidden");
    profilesViewNameInput.focus();
  }
}

function closeProfilesView() {
  profilesView.classList.add("hidden");
  initialView.classList.remove("hidden");
}

function openIncidentsView() {
  let states = incidentView.querySelectorAll("div[id*=state]");
  states.forEach((state) => {
    state.classList.add("hidden");
  });

  fetch(baseURL + "getIncidentsAsync")
    .then((response) => response.json())
    .then((json) => {
      json.forEach((record) => renterIncidents.push(record));

      renterIncidents.sort(function (a, b) {
        return b.customer_name.toUpperCase() - a.customer_name.toUpperCase();
      });
    })
    .then(() =>
      renterIncidents.forEach((incident) => console.log(incident.customer_name))
    );

  incidentViewState1.classList.remove("hidden");
  incidentView.classList.remove("hidden");
}

// || interaction-view functions
function closeInteractionView() {
  interactionView.classList.add("hidden");
  initialView.classList.remove("hidden");
}

// || interaction-view event listeners
// state1
interactionViewCancelButton.addEventListener("click", closeInteractionView);

interactionViewStartProcessButton.addEventListener("click", () => {
  currentRenter = currentRenters.find(
    (record) => record.customer_name === interactionViewRenterSelectInput.value
  );
  if (!currentRenter) {
    alert("Invalid name");
  } else {
    paymentFormUserInput.value = currentUser;
    paymentFormCustomerIdInput.value = currentRenter.id;
    interactionViewState1.classList.add("hidden");
    interactionViewState2.classList.remove("hidden");
  }
});

//state2
customerIsPayingButton.addEventListener("click", () => {
  interactionViewState2.classList.add("hidden");
  paymentFormNameInput.value = currentRenter.customer_name;
  interactionViewState2a.classList.remove("hidden");
  paymentFormAmountInput.focus();
});

customerNotPayingButton.addEventListener("click", () => {
  interactionViewState2.classList.add("hidden");
  interactionViewState3.classList.remove("hidden");
});

//state2a

paymentForm.addEventListener("submit", function (e) {
  e.preventDefault();

  if (
    paymentFormAmountInput.value > 100 &&
    paymentFormAmountInput.value < 15000
  ) {
    let formData = new FormData(paymentForm);
    fetch(
      "http://sbr_code_igniter_4.localhost/Admin/Payments/savePaymentAsync",
      {
        method: "POST",
        body: formData,
      }
    )
      .then((response) => response.json())
      .then((json) => {
        if (json.success === null) {
          throw json.error;
        } else {
          console.log(json.success);
          updateCurrentRenters(json);

          return fetch(
            "http://sbr_code_igniter_4.localhost/Admin/Payments/sendConfirmationEmailAsync",
            {
              method: "POST",
              body: formData,
            }
          );
        }
      })
      .then((response) => response.json())
      .then((json) => {
        if (json.success === null) {
          throw json.error;
        } else {
          console.log(json.success);
        }
      })
      .then(() => {
        interactionViewState2a.classList.add("hidden");
        interactionViewState3.classList.remove("hidden");
      })
      .catch((error) => alert(error));
  } else {
    alert("Coi lại khoản tiền");
  }
});

paymentFormCancelButton.addEventListener("click", () => {
  interactionViewState2a.classList.add("hidden");
  interactionViewState2.classList.remove("hidden");
});

// state3
customerIsExchangingButton.addEventListener("click", () => {
  // clear the datalist so we don't fill it more than once
  interactionViewBikeList.innerHTML = "";

  bikeDataList.forEach((el) => {
    let option = document.createElement("option");
    option.value = el;
    interactionViewBikeList.appendChild(option);
  });
  interactionViewState3.classList.add("hidden");
  interactionViewState3a.classList.remove("hidden");
  exchangeFormBikeOutInput.focus();
});

customerNotExchangingButton.addEventListener("click", () => {
  interactionViewState3.classList.add("hidden");
  interactionViewState4.classList.remove("hidden");
});

// state3a
exchangeFormCancelButton.addEventListener("click", () => {
  interactionViewState3a.classList.add("hidden");
  interactionViewState3.classList.remove("hidden");
});

exchangeFormSubmitButton.addEventListener("click", () => {
  // validate input values
  if (!bikeDataList.includes(exchangeFormBikeInInput.value)) {
    alert("Coi lại biển số xe nhận từ khách");
  } else if (!bikeDataList.includes(exchangeFormBikeOutInput.value)) {
    alert("Coi lại biển số xe đưa cho khách");
  } else {
    // assign values to be inserted into bike_status_change table
    bikeIn.user = currentUser;
    bikeIn.plateNumber = exchangeFormBikeInInput.value;
    bikeIn.newStatus = "Saigon Bike Rentals";
    bikeIn.customerId = "";

    const formData1 = new FormData();
    formData1.append("user", bikeIn.user);
    formData1.append("plate_number", bikeIn.plateNumber);
    formData1.append("new_status", bikeIn.newStatus);
    formData1.append("customer_id", bikeIn.customerId);

    bikeOut.user = currentUser;
    bikeOut.plateNumber = exchangeFormBikeOutInput.value;
    bikeOut.newStatus = currentRenter.customer_name;
    bikeOut.customerId = currentRenter.id;

    const formData2 = new FormData();
    formData2.append("user", bikeOut.user);
    formData2.append("plate_number", bikeOut.plateNumber);
    formData2.append("new_status", bikeOut.newStatus);
    formData2.append("customer_id", bikeOut.customerId);

    fetch("http://sbr_code_igniter_4.localhost/Admin/MoveBike/saveAsync", {
      method: "POST",
      body: formData1,
    })
      .then((response) => response.json())
      .then((json) => {
        if (!json.success) {
          // throw json.error;
          alert(json.error);
        } else {
          console.log(json.success);
          // if a customer record was updated, json.customer will be set and we'll use it to update currentRenters
          if (json.customer !== undefined) {
            updateCurrentRenters(json);
          }

          return fetch(
            "http://sbr_code_igniter_4.localhost/Admin/MoveBike/saveAsync",
            {
              method: "POST",
              body: formData2,
            }
          );
        }
      })
      .then((response) => response.json())
      .then((json) => {
        if (!json.success) {
          throw json.error;
        } else {
          console.log(json.success);
          // if a customer record was updated, json.customer will be set and we'll use it to update currentRenters
          if (json.customer !== undefined) {
            updateCurrentRenters(json);
          }

          interactionViewState3a.classList.add("hidden");
          interactionViewState3b.classList.remove("hidden");
        }
      })
      .catch((error) => console.log(error));
  }
});

// state3b
openRepairAndReturnTicketButton.addEventListener("click", () => {
  const formData1 = new FormData();
  formData1.append("plate_number", bikeIn.plateNumber);
  formData1.append("customer_id", currentRenter.id);
  formData1.append("return_to", currentRenter.customer_name);

  fetch(
    "http://sbr_code_igniter_4.localhost/Admin/RepairAndReturnTickets/saveAsync",
    {
      method: "POST",
      body: formData1,
    }
  )
    .then((response) => response.json())
    .then((json) => {
      if (!json.success) {
        throw json.error;
      } else {
        console.log(json.success);
        // change the plate_number value to the outgoing back now
        formData1.append("customer_name", currentRenter.customer_name);
        formData1.set("plate_number", bikeOut.plateNumber);
        return fetch(
          "http://sbr_code_igniter_4.localhost/Admin/TempLoaners/saveAsync",
          {
            method: "POST",
            body: formData1,
          }
        );
      }
    })
    .then((response) => response.json())
    .then((json) => {
      if (!json.success) {
        throw json.error;
      } else {
        console.log(json.success);
        interactionViewState3b.classList.add("hidden");
        interactionViewState4.classList.remove("hidden");
      }
    })
    .catch((error) => console.log(error));
});

closeRepairAndReturnTicketButton.addEventListener("click", () => {
  const formData = new FormData();
  formData.append("plate_number", bikeOut.plateNumber);

  fetch(
    "http://sbr_code_igniter_4.localhost/Admin/RepairAndReturnTickets/closeRepairTicketAsync",
    {
      method: "POST",
      body: formData,
    }
  )
    .then((response) => response.json())
    .then((json) => {
      if (!json.success) {
        throw json.error;
      } else {
        console.log(json.success);
        formData.append("customer_name", currentRenter.customer_name);
        return fetch(
          "http://sbr_code_igniter_4.localhost/Admin/TempLoaners/closeTicketAsync",
          {
            method: "POST",
            body: formData,
          }
        );
      }
    })
    .then((response) => response.json())
    .then((json) => {
      if (!json.success) {
        throw json.error;
      } else {
        console.log(json.success);
        interactionViewState3b.classList.add("hidden");
        interactionViewState4.classList.remove("hidden");
      }
    })
    .catch((error) => alert(error));
});

// state4
submitCustomerInteractionNoteButton.addEventListener("click", () => {
  if (customerInteractionNotesInput.value === "") {
    interactionView.classList.add("hidden");
    initialView.classList.remove("hidden");
  } else {
    const formData = new FormData();
    formData.append("customer_name", currentRenter.customer_name);
    formData.append("customer_id", currentRenter.id);
    formData.append("notes", customerInteractionNotesInput.value);

    fetch(
      "http://sbr_code_igniter_4.localhost/Admin/CustomerInteractionNotes/create",
      {
        method: "POST",
        body: formData,
      }
    )
      .then((response) => response.json())
      .then((json) => {
        if (!json.success) {
          throw json.error;
        } else {
          console.log(json.success);
          interactionView.classList.add("hidden");
          initialView.classList.remove("hidden");
        }
      })
      .catch((error) => console.log(error));
  }
});

// || newContractView functions
contractCancelButton.addEventListener("click", () => {
  newContractView.classList.add("hidden");
  initialView.classList.remove("hidden");
});

newContractForm.addEventListener("submit", (evt) => {
  evt.preventDefault();
  if (!bikeDataList.includes(contractCurrentBikeInput.value)) {
    alert("Coi lại biển số xe!");
  } else {
    contractCustomerNameInput.value =
      contractFirstNameInput.value.trim() +
      " " +
      contractSurnameInput.value.trim();

    // find the matching record in currentBikes and assign its model as value of the model input
    currentBikes.forEach((el) => {
      if (el.plate_number == contractCurrentBikeInput.value) {
        contractModelInput.value = el.model;
      }
    });

    let formData = new FormData(evt.target);

    fetch("http://sbr_code_igniter_4.localhost/Admin/Customers/saveAsync", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((json) => {
        if (!json.success) {
          throw json.error;
        } else {
          console.log(json.success);
          // if json.success is set then so is json.customers and we can update currentRenters
          updateCurrentRenters(json);
          formData.delete("passport");
          formData.delete("TRC_or_visa");
          formData.delete("license_front");
          formData.delete("license_back");

          return fetch(
            "http://sbr_code_igniter_4.localhost/Admin/Customers/emailAsync",
            {
              method: "POST",
              body: formData,
            }
          );
        }
      })
      .then((response) => response.json())
      .then((json) => {
        if (!json.success) {
          throw json.error;
        } else {
          console.log(json.success);
          newContractView.classList.add("hidden");
          initialView.classList.remove("hidden");
        }
      })
      .catch((error) => alert(error));
  }
});

// || profilesView functions

profilesViewMobileBackButton.addEventListener("click", closeProfilesView);
profilesViewBackButton.addEventListener("click", closeProfilesView);
profilesViewTableBackButton.addEventListener("click", closeProfilesView);

// get all current renters and populate the table with relevant values
profilesViewCurrentRentersButton.addEventListener("click", () => {
  profilesViewCurrentFilterWindow.style.display = "none";
  console.log(currentRenters);
  populateRenterTable(currentRenters);

  profilesViewDesktopState1.classList.add("hidden");
  profilesViewDesktopState2.classList.remove("hidden");
});

// add click event listeners to open correct filter window when filter button is pressed (by checking the data-filter variable)
profilesViewFilterButtons.forEach((button) => {
  button.addEventListener("click", (evt) => {
    // If the filter window is already open no other column should be filterable until it's closed
    if (profilesViewCurrentFilterWindow.style.display === "none") {
      // remove any inputs already present
      profilesViewCurrentFilterInputs.innerHTML = "";

      filterColumn = evt.target.dataset.column;
      filterColumnType = null; //reset this so we don't accidentally reuse the wrong type

      if (evt.target.dataset.filter === "exact-match") {
        createDatalist(
          profilesViewCurrentFilterInputs,
          profilesViewRenterTable,
          button
        );
      } else if (evt.target.dataset.filter === "date-range") {
        let input1 = document.createElement("input");
        input1.setAttribute("type", "date");
        input1.setAttribute("value", currentDate);
        let input2 = document.createElement("input");
        input2.setAttribute("type", "date");
        input2.setAttribute("value", currentDate);
        profilesViewCurrentFilterInputs.appendChild(input1);
        profilesViewCurrentFilterInputs.appendChild(input2);
      } else if (evt.target.dataset.filter === "number-range") {
        let input1 = document.createElement("input");
        filterColumnType = "number"; // we need this in order to know the correct callback to use when sorting
        input1.setAttribute("type", "number");
        let input2 = document.createElement("input");
        input2.setAttribute("type", "number");
        profilesViewCurrentFilterInputs.appendChild(input1);
        profilesViewCurrentFilterInputs.appendChild(input2);
      }
      profilesViewCurrentFilterWindow.style.display = "flex";
    }
  });
});

// if user changes their mind and hits cancel we remove the inputs and hide the filter window
profilesViewCurrentCancelFilterButton.addEventListener("click", () => {
  profilesViewCurrentFilterInputs.innerHTML = "";
  profilesViewCurrentFilterWindow.style.display = "none";
});

profilesViewCurrentApplyFilterButton.addEventListener("click", (evt) => {
  // grab the filter inputs and check length to determine if we're looking for an exact or in range match
  let inputs = profilesViewCurrentFilterInputs.querySelectorAll("input");
  if (inputs.length === 1) {
    matchFilter(profilesViewRenterTable, inputs[0].value);
  }
  // if length !== 1 then we need to check whether type is number and, if so, coerce the input values to numbers
  // make sure that the 2nd value isn't less than the 1st and then apply our range filter
  else if (inputs[0].type === "number") {
    if (Number(inputs[1].value) < Number(inputs[0].value)) {
      alert("2nd value cannot be less than 1st value");
      evt.preventDefault();
    } else {
      rangeFilter(
        profilesViewRenterTable,
        Number(inputs[0].value),
        Number(inputs[1].value)
      );
    }
  }
  // anything not already filtered must be a date
  else {
    //again make sure that the 2nd value isn't less than the 1st and if so apply the range filter to the raw values
    if (inputs[1].value < inputs[0].value) {
      alert("2nd value cannot be less than 1st value");
      evt.preventDefault();
    } else {
      rangeFilter(profilesViewRenterTable, inputs[0].value, inputs[1].value);
    }
  }

  // remember to enable the removeFiltersButton, remove any inputs in the filterWindow and and then hide the filterWindow
  profilesViewRemoveFiltersButton.removeAttribute("disabled");
  profilesViewCurrentFilterInputs.innerHTML = "";
  profilesViewCurrentFilterWindow.style.display = "none";
});

profilesViewRemoveFiltersButton.addEventListener("click", (evt) => {
  let rows = profilesViewRenterTable.querySelectorAll("tr");
  rows.forEach((row) => {
    row.classList.remove("hidden");
  });
  evt.target.setAttribute("disabled", true);
});

// function to filter rows based on value within a range
function rangeFilter(table, val1, val2) {
  // iterate over the rows of the table, checking only the value of the relevant column and hiding the row
  // if the value isn't in the specified range
  let rows = table.rows;
  for (let index = 2; index < rows.length; index++) {
    if (!rows[index].classList.contains("hidden")) {
      let cells = rows[index].children;
      let value = cells[filterColumn].textContent;

      // check if cell contains an input element by selecting and assigning to a variable
      let input = cells[filterColumn].querySelector("input");

      // then, if input variable isn't null we'll grab its value
      if (input) {
        value = input.value;
      }

      if (!(value >= val1 && value <= val2)) {
        rows[index].classList.add("hidden");
      }
    }
  }
}

function matchFilter(table, val) {
  // iterate over the visible rows of the table, checking only the value of the relevant column and hiding the row
  // if the value isn't an exact match
  let rows = table.rows;
  for (let index = 2; index < rows.length; index++) {
    if (!rows[index].classList.contains("hidden")) {
      let cells = rows[index].children;
      let value = cells[filterColumn].textContent;

      // check if cell contains an input element by selecting and assigning to a variable
      let input = cells[filterColumn].querySelector("input");

      // then, if input variable isn't null we'll grab its value
      if (input) {
        value = input.value;
      }

      if (value !== val) {
        rows[index].classList.add("hidden");
      }
    }
  }
}

// Use this to create a datalist when filter button is pressed on a column to be filtered by exact match
function createDatalist(parentNode, table, button) {
  let input = document.createElement("input");
  parentNode.appendChild(input);

  // we want to attach a datalist containing all values in the filterButton's column
  // so first we need to add a list attribute to the input
  let listName = "column-" + button.dataset.column;
  let datalist = document.createElement("datalist");
  datalist.setAttribute("id", listName);
  input.setAttribute("list", listName);

  // and then we have to iterate over the table rows getting the values from the relevant VISIBLE columns
  let rows = table.rows;
  let optionValues = [];

  for (let index = 2; index < rows.length; index++) {
    // for each visible row we grab the cells and check the value of the one in the correct column

    if (!rows[index].classList.contains("hidden")) {
      let cells = rows[index].children;
      let value = cells[filterColumn].textContent;

      // check if cell contains an input element by selecting and assigning to a variable
      let input = cells[filterColumn].querySelector("input");

      // then, if input variable isn't null we'll grab its value
      if (input) {
        value = input.value;
      }

      // but only use it if it's not empty string or white space
      if (value.trim() !== "") {
        optionValues.push(value);
      }
    }
  }

  // now we've got all the required values and it's time to clean them up a bit
  // it's nicer if our options are unique and sorted alphabetically so we'll assign values to a set and then to our datalist
  let tempSet = new Set(optionValues);
  optionValues = [...tempSet];
  optionValues.sort();

  // no we'll go ahead and populate the datalist
  optionValues.forEach((optionValue) => {
    let option = document.createElement("option");
    option.value = optionValue;
    datalist.appendChild(option);
  });

  // don't forget to attach it to the parent node!
  parentNode.appendChild(datalist);
}

profilesViewSortAscendingButton.addEventListener("click", () => {
  // create an array for the visible rows
  let visibleRows = [];
  // grab the table's rows and iterate over them (skipping the first), creating an array for any not currently hidden
  // and then pushing this array onto onto visibleRows[]
  profilesViewRenterTable.querySelectorAll("tr").forEach((row, index) => {
    if (!row.classList.contains("hidden") && index > 1) {
      visibleRows.push(row);
      row.remove(); // remove the row so we don't end up with doubles
    }
  });

  if (filterColumnType === "number") {
    visibleRows.sort((a, b) => {
      return (
        a.children[filterColumn].textContent -
        b.children[filterColumn].textContent
      );
    });
  } else {
    visibleRows.sort((a, b) => {
      return a.children[filterColumn].textContent
        .toLowerCase()
        .localeCompare(b.children[filterColumn].textContent.toLowerCase());
    });
  }

  // now iterate over visibleRows, creating a new <tr> for each of its arrays
  visibleRows.forEach((row) => {
    profilesViewRenterTable.appendChild(row);
  });
});

profilesViewSortDescendingButton.addEventListener("click", () => {
  // create an array for the visible rows
  let visibleRows = [];
  // grab the table's rows and iterate over them (skipping the first), creating an array for any not currently hidden
  // and then pushing this array onto onto visibleRows[]
  profilesViewRenterTable.querySelectorAll("tr").forEach((row, index) => {
    if (!row.classList.contains("hidden") && index > 1) {
      visibleRows.push(row);
      row.remove(); // remove the row so we don't end up with doubles
    }
  });

  if (filterColumnType === "number") {
    visibleRows.sort((a, b) => {
      return (
        b.children[filterColumn].textContent -
        a.children[filterColumn].textContent
      );
    });
  } else {
    visibleRows.sort((a, b) => {
      return b.children[filterColumn].textContent
        .toLowerCase()
        .localeCompare(a.children[filterColumn].textContent.toLowerCase());
    });
  }
  // now iterate over visibleRows, creating a new <tr> for each of its arrays
  visibleRows.forEach((row) => {
    // let row = document.createElement("tr");
    // // then iterate over the indices of the individual arrays, creating and appending a cell to the <tr> for each value
    // el.forEach((value) => {
    //   let cell = document.createElement("td");
    //   cell.innerHTML = value;
    //   row.appendChild(cell);
    // });
    profilesViewRenterTable.appendChild(row);
  });
});

function populateRenterTable(renterArray) {
  // first clear current table contents
  let rows = profilesViewRenterTable.querySelectorAll("tr");
  rows.forEach((row, index) => {
    if (index > 1) {
      row.remove();
    }
  });
  console.log(renterArray);
  renterArray.forEach((renter) => {
    let row = document.createElement("tr");
    let cell0 = document.createElement("td");
    cell0.innerHTML = renter.id;
    row.appendChild(cell0);
    let cell1 = document.createElement("td");
    cell1.innerHTML = renter.customer_name;
    row.appendChild(cell1);
    let cell2 = document.createElement("td");
    cell2.innerHTML = renter.nationality;
    row.appendChild(cell2);
    let cell3 = document.createElement("td");
    cell3.innerHTML = renter.rent;
    row.appendChild(cell3);
    let cell4 = document.createElement("td");
    cell4.innerHTML = renter.current_bike;
    row.appendChild(cell4);
    let cell5 = document.createElement("td");
    cell5.innerHTML = renter.model;
    row.appendChild(cell5);
    let cell6 = document.createElement("td");
    cell6.innerHTML = renter.start_date;
    row.appendChild(cell6);
    let cell7 = document.createElement("td");
    cell7.innerHTML = renter.finish_date;
    row.appendChild(cell7);
    let cell8 = document.createElement("td");
    cell8.innerHTML = renter.paid_up_to;
    row.appendChild(cell8);
    let cell9 = document.createElement("td");
    cell9.innerHTML = renter.last_payment;
    row.appendChild(cell9);

    // Add one more cell to add our profileButton and add an event listener which will update currentRenter
    // and open the individual profile view
    let cell10 = document.createElement("td");
    let profileButton = document.createElement("button");
    profileButton.innerHTML = "profile";
    profileButton.classList.add("profiles-view-filter-button");
    profileButton.classList.add("forward");

    profileButton.addEventListener("click", () => {
      currentRenter = currentRenters.find((record) => record.id === renter.id);
      profilesViewDesktopState2.classList.add("hidden");
      profilesViewState3.classList.remove("hidden");

      nationalitiesDataList.forEach((el) => {
        let option = document.createElement("option");
        option.value = el;
        renterUpdateNationalitiesList.appendChild(option);
      });

      displayIndividualProfile();
    });

    cell10.appendChild(profileButton);
    row.appendChild(cell10);
    profilesViewRenterTable.appendChild(row);
  });
}

// state3 functionality
// sets up the initial appearance of the individual profile
function displayIndividualProfile() {
  // hide payment history and submitButton to start
  paymentHistorySection.classList.add("hidden");
  renterUpdateSubmitButton.classList.add("hidden");
  renterDetailsSection.classList.remove("hidden");
  renterDetailsTab.style.zIndex = 3;
  paymentHistoryTab.style.zIndex = 1;

  // clear paymentHistoryCustomerInfo table
  let rows = paymentHistoryCustomerInfo.querySelectorAll("tr");
  if (rows[1]) {
    rows[1].remove();
  }

  renterDetailsTab.addEventListener("click", (evt) => {
    let styles = getComputedStyle(evt.target);
    let zIndex = styles.getPropertyValue("z-index");
    if (zIndex == 1) {
      evt.target.style.zIndex = 3;
      paymentHistoryTab.style.zIndex = 1;
      renterDetailsSection.classList.remove("hidden");
      paymentHistorySection.classList.add("hidden");
    }
  });

  // clicking on paymentHistoryTab will check the z-index to see whether it's showing or hidden
  // if it's hidden we'll increase its z-index, lower that of the other tab, hide renterDetailsSection
  // and show paymentHistorySection
  paymentHistoryTab.addEventListener("click", (evt) => {
    let styles = getComputedStyle(evt.target);
    let zIndex = styles.getPropertyValue("z-index");

    if (zIndex == 1) {
      evt.target.style.zIndex = 3;
      renterDetailsTab.style.zIndex = 1;
      renterDetailsSection.classList.add("hidden");
      paymentHistorySection.classList.remove("hidden");
    }
  });

  // add customer info
  let row = document.createElement("tr");
  let rowCell0 = document.createElement("td");
  rowCell0.innerHTML = currentRenter.id;
  row.appendChild(rowCell0);
  let rowCell1 = document.createElement("td");
  rowCell1.innerHTML = currentRenter.customer_name;
  row.appendChild(rowCell1);
  let rowCell2 = document.createElement("td");
  rowCell2.innerHTML = currentRenter.start_date;
  row.appendChild(rowCell2);
  let rowCell3 = document.createElement("td");
  rowCell3.innerHTML = currentRenter.paid_up_to;
  row.appendChild(rowCell3);
  paymentHistoryCustomerInfo.appendChild(row);

  // populate inputs with values from currentRenter
  renterUpdateCustomerIdInput.value = currentRenter.id;
  renterUpdateCustomerNameInput.value = currentRenter.customer_name;
  renterUpdateStartDateInput.value = currentRenter.start_date;
  renterUpdateNationalityInput.value = currentRenter.nationality;
  renterUpdateEmailInput.value = currentRenter.email_address;
  renterUpdatePhoneNumberInput.value = currentRenter.phone_number;
  renterUpdateCurrentBikeInput.value = currentRenter.current_bike;
  renterUpdateModelInput.value = currentRenter.model;
  renterUpdateDepositTypeInput.value = currentRenter.deposit_type;
  renterUpdateRentInput.value = currentRenter.rent;
  renterUpdateNotesInput.value = currentRenter.notes;
  renterUpdateBuildingNameInput.value = currentRenter.building_name;
  renterUpdatBuildingNumberInput.value = currentRenter.building_number;
  renterUpdateStreetNameInput.value = currentRenter.street_name;
  renterUpdateWardInput.value = currentRenter.ward;
  renterUpdateDistrictInput.value = currentRenter.district;

  if (currentRenter.passport) {
    passportImage.setAttribute(
      "src",
      "http://sbr_code_igniter_4.localhost/Admin/Photos/displayPhoto/" +
        currentRenter.passport
    );
  }

  if (currentRenter.TRC_or_visa) {
    visaImage.setAttribute(
      "src",
      "http://sbr_code_igniter_4.localhost/Admin/Photos/displayPhoto/" +
        currentRenter.TRC_or_visa
    );
  }

  if (currentRenter.license_front) {
    licenseFrontImage.setAttribute(
      "src",
      "http://sbr_code_igniter_4.localhost/Admin/Photos/displayPhoto/" +
        currentRenter.license_front
    );
  }

  if (currentRenter.license_back) {
    licenseBackImage.setAttribute(
      "src",
      "http://sbr_code_igniter_4.localhost/Admin/Photos/displayPhoto/" +
        currentRenter.license_back
    );
  }

  // get current renter's payments
  let formData = new FormData();
  formData.append("id", currentRenter.id);

  fetch(baseURL + "getPaymentHistoryAsync", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((json) => {
      let tbody = paymentHistoryTable.querySelector("tbody");
      // remember to clear any rows already in tbody!
      tbody.innerHTML = "";
      json.forEach((payment) => {
        let tr = document.createElement("tr");
        let cell0 = document.createElement("td");
        cell0.innerHTML = payment.user;
        tr.appendChild(cell0);

        let cell3 = document.createElement("td");
        let input3 = document.createElement("input");
        input3.value = payment.amount;
        input3.setAttribute("readonly", true);
        cell3.appendChild(input3);
        tr.appendChild(cell3);

        let cell4 = document.createElement("td");
        let input4 = document.createElement("input");
        input4.value = payment.months_paid;
        input4.setAttribute("readonly", true);
        cell4.appendChild(input4);
        tr.appendChild(cell4);

        let cell5 = document.createElement("td");
        let input5 = document.createElement("input");
        input5.value = payment.payment_date;
        input5.setAttribute("readonly", true);
        cell5.appendChild(input5);
        tr.appendChild(cell5);

        let cell6 = document.createElement("td");
        let input6 = document.createElement("input");
        input6.value = payment.notes;
        input6.setAttribute("readonly", true);
        cell6.appendChild(input6);
        tr.appendChild(cell6);

        let cell7 = document.createElement("td");
        let input7 = document.createElement("input");
        input7.value = payment.payment_method;
        input7.setAttribute("readonly", true);
        cell7.appendChild(input7);
        tr.appendChild(cell7);

        let cell8 = document.createElement("td");
        let input8 = document.createElement("input");
        input8.value = payment.id;
        input8.setAttribute("disabled", true);
        cell8.appendChild(input8);
        tr.appendChild(cell8);

        let cell9 = document.createElement("td");
        let button = document.createElement("button");
        button.classList.add("forward");
        button.classList.add("edit-payment-button");
        button.innerHTML = "edit";

        // attach event listener to button that will either set its contents to update or upload info to server
        button.addEventListener("click", (evt) => {
          let inputs = tr.querySelectorAll("input");
          if (evt.target.innerHTML === "edit") {
            evt.target.innerHTML = "Update";
            inputs.forEach((input) => {
              input.removeAttribute("readonly");
            });
          } else {
            let formData = new FormData();
            formData.append("amount", inputs[0].value);
            formData.append("months_paid", inputs[1].value);
            formData.append("payment_date", inputs[2].value);
            formData.append("notes", inputs[3].value);
            formData.append("payment_method", inputs[4].value);
            formData.append("id", inputs[5].value);
            formData.append("customer_id", payment.customer_id);

            fetch(baseURL + "updatePaymentAsync", {
              method: "POST",
              body: formData,
            })
              .then((response) => response.json())
              .then((json) => {
                console.log(json.success);
                evt.target.innerHTML = "edit";

                if (json.customer !== undefined) {
                  currentRenter = json.customer;
                  paymentHistoryCustomerInfo.rows[1].children[3].innerHTML =
                    currentRenter.paid_up_to;
                }

                inputs.forEach((input) => {
                  input.setAttribute("readonly", true);
                });
              });
          }
        });

        cell9.appendChild(button);
        tr.appendChild(cell9);
        tbody.appendChild(tr);
      });
    });
}

// have editButton remove readonly attribute from inputs when clicked
renterUpdateEditButton.addEventListener("click", (evt) => {
  evt.preventDefault();
  renterUpdateForm.querySelectorAll("input").forEach((input) => {
    input.removeAttribute("disabled");
  });
  evt.target.classList.add("hidden");
  renterUpdateSubmitButton.classList.remove("hidden");
});

// have the renterUpdateForm submit its values asynchronously
renterUpdateForm.addEventListener("submit", function (e) {
  // stop the form from submitting synchronously and create a new FormData object with the form's values
  e.preventDefault();
  let formData = new FormData(renterUpdateForm);

  let photoBoxes = renterUpdateForm.querySelectorAll(".photo-box");
  photoBoxes.forEach((photoBox) => {
    if (
      photoBox.dataset.image === "loaded" &&
      photoBox.querySelector("input").value === ""
    ) {
      let key = photoBox.querySelector("input").getAttribute("name");
      formData.delete(key);
    }
  });

  // submit async and if successful, update currentRenters -otherwise catch the error and alert user
  fetch(baseURL + "updateAsync", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((json) => {
      if (json.success === null) {
        throw json.error;
      } else {
        console.log(json.success);
        updateCurrentRenters(json);
      }
    })
    .catch((error) => alert(error));

  // finally hide the submitButton, re-display the editButton, and set all inputs back to readonly
  renterUpdateSubmitButton.classList.add("hidden");
  renterUpdateEditButton.classList.remove("hidden");
  renterUpdateForm.querySelectorAll("input").forEach((input) => {
    input.setAttribute("disabled", true);
  });
});

individualProfileBackButton.addEventListener("click", () => {
  profilesViewState3.classList.add("hidden");
  profilesViewDesktopState2.classList.remove("hidden");
});

// incident view functions
// || state1

// open state2, clear all visible inputs, and populate datalists
createIncidentRecordButton.addEventListener("click", () => {
  incidentViewState2
    .querySelectorAll('input:not([type="hidden"])')
    .forEach((input) => (input.value = ""));
  incidentViewState1.classList.add("hidden");
  incidentViewState2.classList.remove("hidden");

  incidentFormRenterList.innerHTML = "";
  incidentFormPlateNumberList.innerHTML = "";

  currentRenterNameList.forEach((el) => {
    let option = document.createElement("option");
    option.value = el;
    incidentFormRenterList.appendChild(option);
  });

  bikeDataList.forEach((el) => {
    let option = document.createElement("option");
    option.value = el;
    incidentFormPlateNumberList.appendChild(option);
  });

  // put focus on first input
  newIncidentForm.querySelector("input").focus();
});

// open state3
viewIncidentRecordButton.addEventListener("click", () => {
  // clear the table body and then populate it with contents of renterIncidents[]
  let tbody = incidentViewRecordTable.querySelector("tbody");
  tbody.innerHTML = "";
  console.log(renterIncidents);

  // create datalist for plate numbers (if it's empty)
  if (incidentViewPlateList.innerHTML === "") {
    bikeDataList.forEach((el) => {
      let option = document.createElement("option");
      option.value = el;
      incidentViewPlateList.appendChild(option);
    });
  }

  renterIncidents.forEach((incident) => {
    let row = document.createElement("tr");

    let cell0 = document.createElement("td");
    cell0.innerHTML = incident.id;
    row.appendChild(cell0);

    let cell1 = document.createElement("td");
    cell1.innerHTML = incident.date;
    row.appendChild(cell1);

    let cell2 = document.createElement("td");
    cell2.innerHTML = incident.type;
    row.appendChild(cell2);

    let cell3 = document.createElement("td");
    cell3.innerHTML = incident.customer_name;
    row.appendChild(cell3);

    let cell4 = document.createElement("td");
    let input4 = document.createElement("input");
    input4.value = incident.plate_number;
    input4.setAttribute("readonly", true);
    input4.setAttribute("list", "incident-view-plate-list"); // add the plate numbers datalist
    cell4.appendChild(input4);
    row.appendChild(cell4);

    let cell5 = document.createElement("td");
    let input5 = document.createElement("input");
    input5.value = incident.cost_incurred;
    input5.setAttribute("readonly", true);
    cell5.appendChild(input5);
    row.appendChild(cell5);

    let cell6 = document.createElement("td");
    let input6 = document.createElement("input");
    input6.value = incident.resolution;
    input6.setAttribute("readonly", true);
    cell6.appendChild(input6);
    row.appendChild(cell6);

    let cell7 = document.createElement("td");
    let button = document.createElement("button");
    button.innerHTML = "edit";
    button.classList.add("profiles-view-filter-button");
    button.classList.add("forward");

    cell7.appendChild(button);
    row.appendChild(cell7);

    // attach event listener to button that will either set its contents to update or upload info to server
    button.addEventListener("click", (evt) => {
      let inputs = row.querySelectorAll("input");
      if (evt.target.innerHTML === "edit") {
        evt.target.innerHTML = "Update";
        inputs.forEach((input) => {
          input.removeAttribute("readonly");
        });
      } else {
        let formData = new FormData();
        formData.append("plate_number", inputs[0].value);
        formData.append("cost", inputs[1].value);
        formData.append("resolution", inputs[2].value);
        formData.append("id", incident.id);

        fetch(baseURL + "updateIncidentAsync", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((json) => {
            console.log(json.success);
            evt.target.innerHTML = "edit";

            inputs.forEach((input) => {
              input.setAttribute("readonly", true);
            });
          });
      }
    });

    tbody.appendChild(row);
  });

  incidentViewState1.classList.add("hidden");
  incidentViewCurrentFilterWindow.style.display = "none";
  incidentViewState3.classList.remove("hidden");
});

// go back to initialView
incidentViewBackButton.addEventListener("click", () => {
  incidentViewState1.classList.add("hidden");
  initialView.classList.remove("hidden");
});

// || state2

// save incident and uptdate renterIncidents[] if successful
newIncidentForm.addEventListener("submit", (e) => {
  e.preventDefault();

  let renter = currentRenters.find(
    (renter) => renter.customer_name === incidentFormCustomerNameInput.value
  );

  incidentFormCustomerIdInput.value = renter.id;
  let formData = new FormData(newIncidentForm);

  // submit async and if successful, update currentRenters and clear all inputs
  // -otherwise catch the error and alert user
  fetch(baseURL + "saveIncidentAsync", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((json) => {
      if (json.success === null) {
        throw json.error;
      } else {
        console.log(json.success);
        renterIncidents.push(json.incident);
        newIncidentForm
          .querySelectorAll("input")
          .forEach((input) => (input.value = ""));
        incidentFormCustomerNameInput.focus();
      }
    })
    .catch((error) => alert(error));
});

// or go back if user decides to cancel
incidentFormCancelButton.addEventListener("click", (evt) => {
  evt.preventDefault();
  incidentViewState2.classList.add("hidden");
  incidentViewState1.classList.remove("hidden");
});

// || state3
incidentViewTableBackButton.addEventListener("click", () => {
  incidentViewState3.classList.add("hidden");
  incidentViewState1.classList.remove("hidden");
});

// add click event listeners to open correct filter window when filter button is pressed (by checking the data-filter variable)
incidentViewFilterButtons.forEach((button) => {
  button.addEventListener("click", (evt) => {
    // If the filter window is already open no other column should be filterable until it's closed
    if (incidentViewCurrentFilterWindow.style.display === "none") {
      // clear any inputs currently inside incidentViewCurrentFilterInputs
      incidentViewCurrentFilterInputs.innerHTML = "";

      filterColumn = evt.target.dataset.column;
      filterColumnType = null; //reset this so we don't accidentally reuse the wrong type

      if (evt.target.dataset.filter === "exact-match") {
        createDatalist(
          incidentViewCurrentFilterInputs,
          incidentViewRecordTable,
          button
        );
      } else if (evt.target.dataset.filter === "date-range") {
        let input1 = document.createElement("input");
        input1.setAttribute("type", "date");
        input1.setAttribute("value", currentDate);
        let input2 = document.createElement("input");
        input2.setAttribute("type", "date");
        input2.setAttribute("value", currentDate);
        incidentViewCurrentFilterInputs.appendChild(input1);
        incidentViewCurrentFilterInputs.appendChild(input2);
      } else if (evt.target.dataset.filter === "number-range") {
        let input1 = document.createElement("input");
        filterColumnType = "number"; // we need this in order to know the correct callback to use when sorting
        input1.setAttribute("type", "number");
        let input2 = document.createElement("input");
        input2.setAttribute("type", "number");
        incidentViewCurrentFilterInputs.appendChild(input1);
        incidentViewCurrentFilterInputs.appendChild(input2);
      }
      incidentViewCurrentFilterWindow.style.display = "flex";
    }
  });
});

// if user changes their mind and hits cancel we remove the inputs and hide the filter window
incidentViewCurrentCancelFilterButton.addEventListener("click", () => {
  incidentViewCurrentFilterInputs.innerHTML = "";
  incidentViewCurrentFilterWindow.style.display = "none";
});

incidentViewCurrentApplyFilterButton.addEventListener("click", (evt) => {
  // grab the filter inputs and check length to determine if we're looking for an exact or in range match
  let inputs = incidentViewCurrentFilterInputs.querySelectorAll("input");
  if (inputs.length === 1) {
    matchFilter(incidentViewRecordTable, inputs[0].value);
  }
  // if length !== 1 then we need to check whether type is number and, if so, coerce the input values to numbers
  // make sure that the 2nd value isn't less than the 1st and then apply our range filter
  else if (inputs[0].type === "number") {
    if (Number(inputs[1].value) < Number(inputs[0].value)) {
      alert("2nd value cannot be less than 1st value");
      evt.preventDefault();
    } else {
      rangeFilter(
        incidentViewRecordTable,
        Number(inputs[0].value),
        Number(inputs[1].value)
      );
    }
  }
  // anything not already filtered must be a date
  else {
    //again make sure that the 2nd value isn't less than the 1st and if so apply the range filter to the raw values
    if (inputs[1].value < inputs[0].value) {
      alert("2nd value cannot be less than 1st value");
      evt.preventDefault();
    } else {
      rangeFilter(incidentViewRecordTable, inputs[0].value, inputs[1].value);
    }
  }

  // remember to enable the removeFiltersButton, remove any inputs in the filterWindow and and then hide the filterWindow
  incidentViewRemoveFiltersButton.removeAttribute("disabled");
  incidentViewCurrentFilterInputs.innerHTML = "";
  incidentViewCurrentFilterWindow.style.display = "none";
});

incidentViewRemoveFiltersButton.addEventListener("click", (evt) => {
  let rows = incidentViewRecordTable.querySelectorAll("tr");
  rows.forEach((row) => {
    row.classList.remove("hidden");
  });
  evt.target.setAttribute("disabled", true);
});

incidentViewSortAscendingButton.addEventListener("click", () => {
  // create an array for the visible rows
  let visibleRows = [];

  // grab the table's rows and iterate over them (skipping the first), creating an array for any not currently hidden
  // and then pushing this array onto onto visibleRows[]
  incidentViewRecordTable.querySelectorAll("tr").forEach((row, index) => {
    if (!row.classList.contains("hidden") && index > 1) {
      visibleRows.push(row);
      row.remove(); // remove the row so we don't end up with doubles
    }
  });

  if (filterColumnType === "number") {
    visibleRows.sort((a, b) => {
      if (!a.children[filterColumn].querySelector("input")) {
        return (
          a.children[filterColumn].textContent -
          b.children[filterColumn].textContent
        );
      } else {
        return (
          a.children[filterColumn].querySelector("input").value -
          b.children[filterColumn].querySelector("input").value
        );
      }
    });
  } else {
    visibleRows.sort((a, b) => {
      if (!a.children[filterColumn].querySelector("input")) {
        return a.children[filterColumn].textContent
          .toLowerCase()
          .localeCompare(b.children[filterColumn].textContent.toLowerCase());
      } else {
        return a.children[filterColumn]
          .querySelector("input")
          .value.toLowerCase()
          .localeCompare(
            b.children[filterColumn].querySelector("input").value.toLowerCase()
          );
      }
    });
  }

  // now iterate over visibleRows, creating a new <tr> for each of its arrays
  visibleRows.forEach((row) => {
    incidentViewRecordTable.querySelector("tbody").appendChild(row);
  });
});

incidentViewSortDescendingButton.addEventListener("click", () => {
  // create an array for the visible rows
  let visibleRows = [];

  // grab the table's rows and iterate over them (skipping the first), creating an array for any not currently hidden
  // and then pushing this array onto onto visibleRows[]
  incidentViewRecordTable.querySelectorAll("tr").forEach((row, index) => {
    if (!row.classList.contains("hidden") && index > 1) {
      visibleRows.push(row);
      row.remove(); // remove the row so we don't end up with doubles
    }
  });

  if (filterColumnType === "number") {
    visibleRows.sort((a, b) => {
      if (!a.children[filterColumn].querySelector("input")) {
        return (
          b.children[filterColumn].textContent -
          a.children[filterColumn].textContent
        );
      } else {
        return (
          b.children[filterColumn].querySelector("input").value -
          a.children[filterColumn].querySelector("input").value
        );
      }
    });
  } else {
    visibleRows.sort((a, b) => {
      if (!a.children[filterColumn].querySelector("input")) {
        return b.children[filterColumn].textContent
          .toLowerCase()
          .localeCompare(a.children[filterColumn].textContent.toLowerCase());
      } else {
        return b.children[filterColumn]
          .querySelector("input")
          .value.toLowerCase()
          .localeCompare(
            a.children[filterColumn].querySelector("input").value.toLowerCase()
          );
      }
    });
  }

  // now iterate over visibleRows, creating a new <tr> for each of its arrays
  visibleRows.forEach((row) => {
    incidentViewRecordTable.querySelector("tbody").appendChild(row);
  });
});

// message view functions
mailForm.addEventListener("submit", (e) => {
  e.preventDefault();
  console.log(currentRenterNameList);
  // make sure name input contains a valid value
  if (
    !currentRenterNameList.includes(namesInput.value) &&
    namesInput.value !== "ALL"
  ) {
    alert("please select a valid name");
  } else {
    // submit message async and show success message if successful
    // -otherwise catch the error and alert user
    let formData = new FormData(mailForm);
    fetch(baseURL + "sendMessage", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((json) => {
        if (json.success === null) {
          throw json.error;
        } else {
          console.log(json.success);
          mailForm.querySelectorAll("input").forEach((input) => {
            input.value = "";
          });
        }
      })
      .catch((error) => alert(error));
  }
});

cancelMessageButton.addEventListener("click", (e) => {
  e.preventDefault();
  messageView.classList.add("hidden");
  initialView.classList.remove("hidden");
});

// || photoBox section
const photoBoxes = document.querySelectorAll(".photo-box");

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
  // const selectButton = el.querySelector(".select-button");
  // const deselectButton = el.querySelector(".deselect-button");

  // all the buttons and the photoImages are hidden initially
  deleteButton.classList.add("hidden");
  removeButton.classList.add("hidden");
  // selectButton.classList.add("hidden");
  // deselectButton.classList.add("hidden");
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
    // selectButton.classList.add("hidden");
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
        // selectButton.classList.remove("hidden");
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

// renterUpdateButton hides photobox placeHolders and displays selectPhoto
renterUpdateEditButton.addEventListener("click", () => {
  photoBoxes.forEach((photoBox) => {
    photoBox.querySelector(".place-holder").classList.add("hidden");
    photoBox.querySelector(".select-photo-wrapper").classList.remove("hidden");

    // if img has loaded then display the deleteButton
    if (photoBox.dataset.image === "loaded") {
      photoBox.querySelector(".delete-button").classList.remove("hidden");
    }
  });
});

// renterUpdateButton hides photobox placeHolders and displays selectPhoto
renterUpdateSubmitButton.addEventListener("click", () => {
  photoBoxes.forEach((photoBox) => {
    photoBox.querySelector(".delete-button").classList.add("hidden");
    // if (photoBox.dataset.image === "loaded") {
    //   photoBox.querySelector("input").value = "penis";
    // }
  });
});
