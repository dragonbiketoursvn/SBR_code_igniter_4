// Create a class for the element
class PopUpInfo extends HTMLElement {
  constructor() {
    // Always call super first in constructor
    super();

    // Create a shadow root
    const shadow = this.attachShadow({ mode: "open" });

    // Create spans
    const container = document.createElement("div");
    container.setAttribute("class", "container");

    let funcName;

    if (this.hasAttribute("data-function")) {
      funcName = this.getAttribute("data-function");
    }

    const button = document.createElement("button");
    button.textContent = "penis";
    // button.addEventListener("click", dick);
    button.addEventListener("click", window[funcName]);

    // Attach the created elements to the shadow dom
    container.appendChild(button);
    shadow.appendChild(container);
  }
}

// Define the new element
customElements.define("popup-info", PopUpInfo);
