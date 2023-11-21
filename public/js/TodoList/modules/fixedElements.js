import { BaseElement } from "./baseElement.js";

class ListHeader extends BaseElement {
    constructor(parentNode, content) {
        super(parentNode);
        this.element = document.createElement('h2');
        this.element.id = 'listHeader';
        this.element.textContent = content;
    }
    draw() {
        this.parentNode.appendChild(this.element);
    }
}

class AddTaskButton extends BaseElement {
    constructor(parentNode, content, clickHandler) {
        super(parentNode);
        this.element = document.createElement('button');
        this.element.id = 'addTask';
        this.element.textContent = content;
        this.element.addEventListener('click', (evt) => {
            clickHandler();
        });
    }
    draw() {
        this.parentNode.appendChild(this.element);
    }
}

class BackButton extends BaseElement {
    constructor(parentNode, content, path) {
        super(parentNode);
        this.element = document.createElement('a');
        this.element.id = 'backButton';
        this.element.textContent = content;
        this.element.href = path;
    }
    draw() {
        this.parentNode.appendChild(this.element);
    }
}

class CancelButton {
    constructor(content, clickHandler) {
        this.element = document.createElement('button');
        this.element.id = 'cancelButton';
        this.element.textContent = content;
        this.element.addEventListener('click', (evt) => {
            clickHandler();
        });
    }
}

export { ListHeader, AddTaskButton, BackButton, CancelButton };