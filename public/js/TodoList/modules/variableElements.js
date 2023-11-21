import { BaseElement } from "./baseElement.js";

// Modal class always creates the #modal and #modalCenter divs
// and then fills the #modalCenter div with either a form and cancel/submit buttons
// OR markDone, Edit, addSubtask, cancel
// Or markDone, Edit, cancel
// so... contentElements[] would contain either [this.taskForm, this.cancelButton, this.submitButton]
// OR [this.markDoneTaskButton, this.editTaskButton, this.addSubtaskButton, this.canceButton]
// OR [this.markDoneSubtaskButton, this.editSubtaskButton, this.canceButton]
// these elements will have already been created and had event listeners attached

class Modal extends BaseElement {
    constructor(parentNode, contentElements = []) {
        super(parentNode);
        this.contentElements = contentElements;
        this.element = document.createElement('div');
        this.element.id = 'modal';
        const modalCenter = document.createElement('div');
        modalCenter.id = 'modalCenter';
        // now append child elements to modalCenter
        contentElements.forEach(contentElement => {
            modalCenter.appendChild(contentElement.element);
        });
        this.element.appendChild(modalCenter);
    }
    draw() {
        this.parentNode.appendChild(this.element);
    }
}

// this class is used for forms displayed in the modal to create or update a task or subtask
// if it is updating an existing record then it should copy all inputs and current values
// from that form
class ModalForm  {
    constructor(type = 'newTask', formID = null) {
        this.type = type;
        this.formID = formID;
        this.element = document.createElement('form');
        this.element.setAttribute('name', 'modalForm');
    }
    addHiddenInput(formID = null) {
        if (formID !== null) {
            const input = document.createElement('input');
            input.setAttribute('name', 'id');
            input.setAttribute('hidden', true);
            this.element.appendChild(input);
        }
    }
    addDescriptionInput() {
        const label = document.createElement('label');
        label.textContent = 'Description';
        label.setAttribute('for', 'descriptionInput');
        this.element.appendChild(label);

        const input = document.createElement('input');
        input.id = 'descriptionInput';
        input.setAttribute('name', 'description');
        this.element.appendChild(input);
    }
    addPlateNumberInput() {
        const label = document.createElement('label');
        label.textContent = 'Plate Number';
        label.setAttribute('for', 'plateNumberInput');
        this.element.appendChild(label);

        const input = document.createElement('input');
        input.id = 'plateNumberInput';
        input.setAttribute('name', 'plate_number');
        this.element.appendChild(input);
    }
    addDateDueInput() {
        const label = document.createElement('label');
        label.textContent = 'Date Due';
        label.setAttribute('for', 'dateDueInput');
        this.element.appendChild(label);

        const input = document.createElement('input');
        input.id = 'dateDueInput';
        input.setAttribute('type', 'date');
        input.setAttribute('name', 'due_date');
        const date = new Date();
        const dateValue = date.toISOString().match(/^.*(?=T)/)[0];
        input.setAttribute('value', dateValue);
        this.element.appendChild(input);
    }
}


class TaskList extends BaseElement {
    static labels = ['Description', 'Plate Number', 'Date Due', 'Select'];

    constructor(parentNode, tasks, selectCurrentFormHandler) {
        super(parentNode);
        this.element = document.createElement('ul');
        this.elements = [];
        const labelRow = new LabelRow(this.element, TaskList.labels);
        this.elements.push(labelRow);

        tasks.forEach(task => {
            const taskRow = new TaskRow(this.element, task, selectCurrentFormHandler);
            this.elements.push(taskRow);

            if (task.subtasks.length > 0) {
                const subtaskList = new SubtaskList(this.element, task.subtasks, selectCurrentFormHandler);
                this.elements.push(subtaskList);
            }
        })
    }
    draw() {
        this.elements.forEach(element => {
            element.draw();
        });
        this.parentNode.appendChild(this.element);
    }
}

class SubtaskList extends BaseElement {
    static labels = ['Description', 'Select'];

    constructor(parentNode, subtasks, selectCurrentFormHandler) {
        super(parentNode);
        this.element = document.createElement('ul');
        this.elements = [];
        const labelRow = new LabelRow(this.element, SubtaskList.labels);
        this.elements.push(labelRow);

        subtasks.forEach(subtask => {
            const subtaskRow = new SubtaskRow(this.element, subtask, selectCurrentFormHandler);
            this.elements.push(subtaskRow);
        })
    }
    draw() {
        this.elements.forEach(element => {
            element.draw();
        });
        this.parentNode.appendChild(this.element);
    }
}

class LabelRow extends BaseElement {
    constructor(parentNode, labels = []) {
        super(parentNode);
        this.element = document.createElement('li');
        const spanContainer = document.createElement('div');
        spanContainer.id = 'spanContainer';
        labels.forEach(label => {
            const labelSpan = document.createElement('span');
            labelSpan.textContent = label;
            labelSpan.classList.add('labelSpan');
            spanContainer.appendChild(labelSpan);
        }); 
        this.element.appendChild(spanContainer);
    }
    draw() {
        this.parentNode.appendChild(this.element);
    }
}

class TaskRow extends BaseElement {
    constructor(parentNode, task, selectHandler) {
        super(parentNode);
        this.element = document.createElement('li');
        const taskForm = document.createElement('form');
        taskForm.setAttribute('name', 'form' + task.id); // allows us named access via document.forms
        taskForm.classList.add('todoForm');
        this.addHiddenInput(taskForm, task);
        this.addDescriptionInput(taskForm, task);
        this.addPlateNumberInput(taskForm, task);
        this.addDateDueInput(taskForm, task);
        this.addSelectCurrentFormInput(taskForm, task, selectHandler);
        this.element.appendChild(taskForm);
    }
    addHiddenInput(taskForm, task) {
        const hiddenIdInput = document.createElement('input');
        hiddenIdInput.value = task.id;
        hiddenIdInput.setAttribute('readonly', true);
        hiddenIdInput.setAttribute('type', 'hidden');
        hiddenIdInput.setAttribute('name', 'id');
        taskForm.appendChild(hiddenIdInput);
    }
    addDescriptionInput(taskForm, task) {
        const descriptionInput = document.createElement('input');
        descriptionInput.classList.add('descriptionInput');
        descriptionInput.value = task.description;
        descriptionInput.setAttribute('readonly', 'description');
        descriptionInput.setAttribute('name', 'description');
        taskForm.appendChild(descriptionInput);   
    }
    addPlateNumberInput(taskForm, task) {
        const plateNumberInput = document.createElement('input');
        plateNumberInput.classList.add('plateNumberInput');
        plateNumberInput.value = task.plate_number;
        plateNumberInput.setAttribute('readonly', true);
        plateNumberInput.setAttribute('name', 'plate_number');
        taskForm.appendChild(plateNumberInput);    
    }
    addDateDueInput(taskForm, task) {
        const dateDueInput = document.createElement('input');
        dateDueInput.classList.add('dateDueInput');
        dateDueInput.value = task.due_date;
        dateDueInput.setAttribute('readonly', true);
        dateDueInput.setAttribute('name', 'due_date');
        taskForm.appendChild(dateDueInput);
    }
    addSelectCurrentFormInput(taskForm, task, selectCurrentFormHandler) {
        const selectCurrentFormInput = document.createElement('input');
        selectCurrentFormInput.classList.add('selectCurrentFormInput');
        selectCurrentFormInput.setAttribute('type', 'radio');
        selectCurrentFormInput.setAttribute('name', 'radio');
        selectCurrentFormInput.addEventListener('input', (evt) => {
            const formName = evt.target.parentNode.name;
            selectCurrentFormHandler(formName);
        });
        taskForm.appendChild(selectCurrentFormInput);
    }
    draw() {
        this.parentNode.appendChild(this.element);
    }
}

class SubtaskRow extends BaseElement {
    constructor(parentNode, subtask, selectCurrentFormHandler) {
        super(parentNode);
        this.element = document.createElement('li');
        const subtaskForm = document.createElement('form');
        subtaskForm.setAttribute('name', 'form' + subtask.id); // allows us named access via document.forms
        subtaskForm.classList.add('subtaskForm');
        this.addHiddenInput(subtaskForm, subtask);
        this.addDescriptionInput(subtaskForm, subtask);
        this.addSelectCurrentFormInput(subtaskForm, subtask, selectCurrentFormHandler);
        this.element.appendChild(subtaskForm);
    }
    addHiddenInput(subtaskForm, subtask) {
        const hiddenIdInput = document.createElement('input');
        hiddenIdInput.value = subtask.id;
        hiddenIdInput.setAttribute('readonly', true);
        hiddenIdInput.setAttribute('type', 'hidden');
        hiddenIdInput.setAttribute('name', 'id');
        subtaskForm.appendChild(hiddenIdInput);
    }
    addDescriptionInput(subtaskForm, subtask) {
        const descriptionInput = document.createElement('input');
        descriptionInput.classList.add('descriptionInput');
        descriptionInput.value = subtask.description;
        descriptionInput.setAttribute('readonly', 'description');
        descriptionInput.setAttribute('name', 'description');
        subtaskForm.appendChild(descriptionInput);   
    }
    addSelectCurrentFormInput(subtask, task, selectCurrentFormHandler) {
        const selectCurrentFormInput = document.createElement('input');
        selectCurrentFormInput.classList.add('selectCurrentFormInput');
        selectCurrentFormInput.setAttribute('type', 'radio');
        selectCurrentFormInput.setAttribute('name', 'radio');
        selectCurrentFormInput.addEventListener('input', (evt) => {
            const formName = evt.target.parentNode.name;
            selectCurrentFormHandler(formName);
        });
        subtask.appendChild(selectCurrentFormInput);
    }
    draw() {
        this.parentNode.appendChild(this.element);
    }
}

class SubmitButton {
    constructor(content, clickHandler) {
        this.element = document.createElement('button');
        this.element.id = 'submitButton';
        this.element.textContent = content;
        this.element.addEventListener('click', (evt) => {
            clickHandler();
        });
    }
}

// class CancelButton {
//     constructor(content, clickHandler) {
//         this.element = document.createElement('button');
//         this.element.id = 'cancelButton';
//         this.element.textContent = content;
//         this.element.addEventListener('click', (evt) => {
//             clickHandler();
//         });
//     }
// }

export { Modal, ModalForm, TaskList, SubtaskList, SubmitButton };