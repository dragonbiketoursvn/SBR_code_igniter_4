const inputs = document.querySelectorAll("input");

const trimInputValue = (e) => {
  e.target.value = e.target.value.trim();
};

if (inputs.length !== 0) {
  inputs.forEach((input) => input.addEventListener("change", trimInputValue));
}
