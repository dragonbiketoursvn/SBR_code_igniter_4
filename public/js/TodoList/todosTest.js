import { ListHeader, AddTaskButton, BackButton, CancelButton } from "./modules/fixedElements.js";
import { Modal, ModalForm, TaskList, SubmitButton } from "./modules/variableElements.js";

const UI = {
    content: {
        listHeader: {
            noTasks: 'Hooray! No tasks!',
            hasTasks: 'Todo List',
        },
        addTaskButton: 'Add Task',
        backButton: 'Back',
        cancelButton: 'Cancel',
        submitButton: 'Submit',
        paths: {
            origin: (new URL(location.href)).origin,
            home: '/Admin/Home',
            getTasks: '/Admin/Todos/getIncomplete',
            addNew: '/Admin/Todos/addTask',
            update: '/Admin/Todos/updateTask',
            markDone: '/Admin/Todos/markDone',
        }
    },
    // docFrag: null,
    elements: [],
    // listHeader: null,
    async initialize() {
        this.docFrag = new DocumentFragment();
        this.tasks = await this.getTasks();
        let listHeaderOption = 'noTasks';
        this.taskList = null;

        if (this.tasks.length > 0) {
            listHeaderOption = 'hasTasks';
            this.taskList = new TaskList(this.docFrag, this.tasks, this.selectCurrentFormRadioClickHandler.bind(this));
        }

        this.listHeader = new ListHeader(this.docFrag, this.content.listHeader[listHeaderOption]);
        this.elements.push(this.listHeader);
        
        if (this.taskList !== null) {
            this.elements.push(this.taskList);
        }

        this.addTaskButton = new AddTaskButton(this.docFrag, this.content.addTaskButton, this.addTaskButtonClickHandler.bind(this));
        this.backButton = new BackButton(this.docFrag, this.content.backButton, `${this.content.paths.origin}${this.content.paths.home}`);
        this.elements.push(this.addTaskButton, this.backButton);
        this.draw();
    },
    draw() {
        this.elements.forEach(element => {
            element.draw();
        });
        document.body.appendChild(this.docFrag);
    },
    async getTasks() {
            const url = `${this.content.paths.origin}${this.content.paths.getTasks}`;
            const response = await fetch(url);
            const result = await response.json();
            const taskList = [];

            result.forEach(todo => {
                if (todo.subtask === '0') {
                    taskList.push(todo);
                }
            });

            const subtasks = result.filter(todo => todo.subtask === '1');

            taskList.forEach(todo => {
                todo.subtasks = subtasks.filter(subtask => subtask.parent_id === todo.id);
            });
            return taskList;
    },
    addTaskButtonClickHandler() {
        // create the modal with a form (for new tasks), a cancelButton, and submitButton
        this.modalForm = new ModalForm();
        this.modalForm.addDescriptionInput();
        this.modalForm.addPlateNumberInput();
        this.modalForm.addDateDueInput();
        this.cancelButton = new CancelButton(this.content.cancelButton, this.cancelButtonClickHandler.bind(this));
        this.submitButton = new SubmitButton(this.content.submitButton, this.submitButtonClickHandler.bind(this));
        console.log(this.submitButton);
        // this.modal = new Modal(this.docFrag, [this.modalForm, this.cancelButton, this.submitButton]);
        this.modal = new Modal(this.docFrag, [this.modalForm, this.submitButton, this.cancelButton]);
        this.elements.push(this.modal);
        this.draw(); 
    },
    cancelButtonClickHandler(formName = null) {
        if (formName !== null) {
            this.resetRadio(formName);
        }
        this.modal.element.remove();
        this.elements = this.elements.filter(element => element !== this.modal);
    },
    async submitButtonClickHandler(formName = null) {
        const modalForm = document.forms.modalForm;
        
        if (this.sanitizeForm(modalForm)) {
            const formData = new FormData(modalForm);
            const path = `${this.content.paths.addNew}`;
            const response = await this.sendPost(formData, path);
            console.log(response);
        } else {
            alert('Please add a description!');
        }
    },
    selectCurrentFormRadioClickHandler(formName) {
        this.cancelButton = new CancelButton(this.content.cancelButton, this.cancelButtonClickHandler.bind(this, formName));
        this.modal = new Modal(this.docFrag, [this.cancelButton]);
        this.elements.push(this.modal);
        this.draw(); 
    },
    resetRadio(formName) {
        const form = document.forms[formName];
        form.elements.radio.remove();
        const selectCurrentFormInput = document.createElement('input');
        selectCurrentFormInput.classList.add('selectCurrentFormInput');
        selectCurrentFormInput.setAttribute('type', 'radio');
        selectCurrentFormInput.setAttribute('name', 'radio');
        const handler = this.selectCurrentFormRadioClickHandler.bind(this);
        selectCurrentFormInput.addEventListener('input', (evt) => {
            handler(formName);
        });
        form.appendChild(selectCurrentFormInput);
    },
    async sendPost(formData, path) {
        const url = `${this.content.paths.origin}${path}`
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
        });
        const result = await response.json();
        
        if (result.message === 'fail') {
            alert('Todo NOT marked done! (error)')
        } else {
            return result;
        }
    },
    sanitizeForm(form) {
        const inputs = form.querySelectorAll('input');
        inputs.forEach(input => {
            input.value = input.value.trim()
        });
        const descriptionInput = form.querySelector('#descriptionInput');
        if (descriptionInput.value === '') {
            return false;
        } else {
            return true;
        }
    }
};

UI.initialize();

// class recordsContainer {
//     // this should create a document fragment containing a <ul>
//     // and all its <li> elements and then append the fragment to
//     // the parentNode
//     constructor(records, parentNode) {
//         this.records = records;
//         this.parentNode = parentNode;
//         this.element = document.createElement('ul');
//         // docFrag.appendChild(this.element);

//         // records.forEach(record => {
//         //     const row = new TaskRow(record, docFrag);
//         // });

//         // parentNode.appendChild(docFrag);
//     }
//     draw() {
//         const docFrag = new DocumentFragment();
//         this.records.forEach(record => {
//             const taskRow = new TaskRow(record, docFrag);
//             taskRow.draw();
//         });
//         this.parentNode.appendChild        
//     }
// }

// class TaskRow {
//     constructor(record, parentNode) {

//     }
//     draw() {

//     }
// }

// const UI = {
//     data: {
//         records: [
//             {id: 1, description: 'balls'},
//             {id: 2, description: 'cock'}
//         ]
//     },
//     container: null,
//     draw() {
//         // we can't specify the precise elements in the container as this depends on the data
//         this.container = new recordsContainer(this.data.records, document.body);
//     }
// }

// create a container element with other elements
// inside and then draw to page

// class ListItem {
//     constructor(parentNode, contents) {
//       this.element = document.createElement('li');
//       this.element.textContent = contents;
//       this.parentNode = parentNode;
//     }
//     draw() {
//       this.parentNode.appendChild(this.element)
//     }
//   }
  
//   class UnorderedList {
//       constructor(parentNode, items = []) {
//       this.element = document.createElement('ul');
//       this.parentNode = parentNode;
//       this.items = items;
//     }
//     draw() {
//       const docFrag = new DocumentFragment();
//       this.items.forEach(item => {
//         const element = new item(docFrag, 'cockamamie');
//         element.draw();
//       });
//       this.element.appendChild(docFrag);
//       this.parentNode.appendChild(this.element);
//     }
//   }
  
//   let testList = new UnorderedList(document.body, [ListItem, ListItem, ListItem]);
//   testList.draw();
  
// const button = document.createElement('button');
// button.textContent = 'penis';
// document.body.appendChild(button);
  
// const test = {
//     body: document.body,
//     initialize() {
//         this.button = document.createElement('button');
//         this.button.textContent = 'penisaurus rex';
//     },
//     draw() {
//         this.body.appendChild(this.button);
//     }
// };

// class TestClass {
//     constructor(parentNode) {
//         this.parentNode = parentNode;
//         this.button = document.createElement('button');
//         this.button.textContent = 'penisaurus cockasaurus';
//     }
//     draw() {
//         this.parentNode.appendChild(this.button);
//     }
// }

// const test = new TestClass(document.body);
// test.draw();

