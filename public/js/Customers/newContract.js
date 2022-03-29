const modal = document.querySelector(".modal");
const buttonOpenModal = document.querySelector(".toggle");
const buttonCloseModal = document.querySelector(".close-toggle");

const form = document.querySelector("#rental_contract");
const first_name = document.querySelector(".first_name");
const surname = document.querySelector(".surname");
let full_name = document.querySelector(".full_name");

form.addEventListener("submit", function (e) {
  first_name.value = first_name.value.toLowerCase();
  let firstArray = [...first_name.value];
  firstArray[0] = firstArray[0].toUpperCase();
  first_name.value = firstArray.join("");

  surname.value = surname.value.toLowerCase();
  let secondArray = [...surname.value];
  secondArray[0] = secondArray[0].toUpperCase();
  surname.value = secondArray.join("");

  full_name.value = first_name.value + " " + surname.value;
});

const toggle = function () {
  modal.classList.add("is-active");
};

const closeToggle = function () {
  modal.classList.remove("is-active");
};

buttonOpenModal.addEventListener("click", toggle);
buttonCloseModal.addEventListener("click", closeToggle);

const UIController = (function () {
  //the private section of the module
  let component = "Replacement Text";
  const changeComponent = function () {
    //change all the h1 text to what is in the component variable above
    const element = document.querySelector("h1");
    element.textContent = component;
  };
  //the public section of the module
  return {
    callChangeComponent: function () {
      changeComponent();
    },
  };
})();
