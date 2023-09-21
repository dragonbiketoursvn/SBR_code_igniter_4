(function () {
  // const FIXER_API_BASE = "http://data.fixer.io/api/";
  // const FIXER_API_KEY = "1eab7800720a67d57ee29ae5dd6ca378";

  // We need global access to the USD_TO_VND and VND_TO_USD exchange rates
  // Since we obtain these values via async request we need to declare them outside
  // the async function (which we writ as an IIFE so that it runs as soon as the script
  // has loaded)

  const USD_TO_VND = document.querySelector("#usd_to_vnd").value;
  const VND_TO_USD = document.querySelector("#vnd_to_usd").value;

  // (async function () {
  //   const response = await fetch(
  //     `${FIXER_API_BASE}latest?access_key=${FIXER_API_KEY}&symbols=USD,VND`
  //   );
  //   const json = await response.json();
  //   const USD_TO_EURO = Number(json.rates.USD);
  //   const VND_TO_EURO = Number(json.rates.VND);
  //   USD_TO_VND = (1 / USD_TO_EURO) * VND_TO_EURO;
  //   VND_TO_USD = 1 / USD_TO_VND;
  // })();

  // Typing a value into the USD and VND inputs will automatically update the
  // other input control with the equivalent, converted value

  const rentInput = document.querySelector("#rent");
  const rentInputUSD = document.querySelector("#rent_usd");

  const convertDongToDollars = (e) => {
    rentInputUSD.value = (e.target.value * VND_TO_USD * 1000).toFixed(2);
  };

  const convertDollarsToDong = (e) => {
    rentInput.value = ((e.target.value * USD_TO_VND) / 1000).toFixed(0);
  };

  if (rentInput !== null) {
    rentInput.addEventListener("input", convertDongToDollars);
  }

  if (rentInputUSD !== null) {
    rentInputUSD.addEventListener("input", convertDollarsToDong);
  }
})();
