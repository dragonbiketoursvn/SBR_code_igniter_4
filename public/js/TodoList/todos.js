// create objects/classes which will do the following:
// asynchronously fetch data from API
// create DOM elements to hold data
// create DOM elements to add/update data

const TodoList = {
    origin: new URL(location.href).origin,
    incompleteTodosURL: null,
    dataPath: '/Admin/Todos/getIncomplete',
    markDonePath: '/Admin/Todos/markDone',
    addTaskPath: '/Admin/Todos/addTask',
    updateTaskPath: '/Admin/Todos/updateTask',
    addSubtaskPath: '/Admin/Todos/addSubtask',
    updateSubtaskPath: '/Admin/Todos/updateSubtask',
    homePath: '/Admin/Home',
    incompleteTasks: [],
    eventListeners: {
        openModal(evt) {
            let formID;
            if (evt.target.parentNode.elements !== undefined) {
                formID = evt.target.parentNode.elements.id.value;
            }
            const modal = document.createElement('div');
            modal.id = 'modal';
            document.body.appendChild(modal);
            const modalCenter = document.createElement('div');
            modalCenter.id = 'modalCenter';
            this.eventListeners.addButtons(modalCenter, formID);
            modal.appendChild(modalCenter);
        },
        addButtons(modalcenter, formID) {
            const markDoneButton = document.createElement('button');
            markDoneButton.id = 'markDoneButton';
            markDoneButton.textContent = 'Mark Done';
   
            markDoneButton.addEventListener('click', (evt) => {
                TodoList.eventListeners.updateRecordMarkDone(evt, formID);
            });
            modalcenter.appendChild(markDoneButton);
            
            const editButton = document.createElement('button');
            editButton.id = 'editButton';
            editButton.textContent = 'Edit';
            editButton.addEventListener('click', (evt) => {
                TodoList.eventListeners.addTaskUpdateForm(evt, formID);
            });
            modalcenter.appendChild(editButton);

            const addSubtaskButton = document.createElement('button');
            addSubtaskButton.id = 'addSubtaskButton';
            addSubtaskButton.textContent = 'Add Subtask';
            addSubtaskButton.addEventListener('click', (evt) => {
                TodoList.eventListeners.addSubtask(evt, formID);
            });
            modalcenter.appendChild(addSubtaskButton);
        },
        async updateRecordMarkDone(evt, formID) {

            const url = `${TodoList.origin}${TodoList.markDonePath}`;
            const form = new FormData();
            form.append('id', formID);
            const response = await fetch(url, {
                method: 'POST',
                body: form,
            });
            const result = await response.json();
            
            if (result.message === 'fail') {
                alert('Todo NOT marked done! (error)')
            }
            
            TodoList.eventListeners.closeModalAndReset(evt, formID);
            TodoList.eventListeners.removeCompletedTask(evt, formID);
        },
        closeModalAndReset(evt, formID) {
            const modalCenter = evt.target.parentNode;
            const modal = modalCenter.parentNode;
            modal.remove();
            TodoList.eventListeners.resetRadio(evt, formID);
        },
        resetRadio(evt, formID) {
            const formName = `form${formID}`;
            const form = document.forms[formName];
            let radio = form.radio;
            radio.remove();
            radio = document.createElement('input');
            radio.setAttribute('type', 'radio');
            radio.setAttribute('name', 'radio');
            radio.classList.add('selectInput');
            radio.addEventListener('input', this.eventListeners.openModal);
            form.appendChild(radio);
        },
        removeCompletedTask(evt, formID) {
            const formName = `form${formID}`;
            const form = document.forms[formName];
            form.remove();
        },
        addTaskUpdateForm(evt, formID) {
            // clear the modal
            const modalCenter = evt.target.parentNode;
            TodoList.eventListeners.clearModalCenter(modalCenter);

            // copy the form and remove the radio button
            const formName = `form${formID}`;
            const form = document.forms[formName];
            const formCopy = form.cloneNode(true);
            formCopy.radio.remove();

            // make inputs writeable, update class, and add to DOM
            TodoList.eventListeners.makeFormWriteable(formCopy);
            formCopy.classList.remove('todoForm');
            formCopy.classList.add('updateForm');
            modalCenter.appendChild(formCopy);

            // add submit and cancel buttons
            TodoList.eventListeners.addSubmitAndCancelButtons(modalCenter, formID, TodoList.updateTaskPath); 
        },
        addSubtaskUpdateForm(evt, formID) {
            // clear the modal
            const modalCenter = evt.target.parentNode;
            TodoList.eventListeners.clearModalCenter(modalCenter);

            // copy the form and remove the radio button
            const formName = `form${formID}`;
            const form = document.forms[formName];
            const formCopy = form.cloneNode(true);
            formCopy.radio.remove();
            formCopy.plateNumberInput.remove();

            // make inputs writeable, update class, and add to DOM
            TodoList.eventListeners.makeFormWriteable(formCopy);
            formCopy.classList.remove('todoForm');
            formCopy.classList.add('updateForm');
            modalCenter.appendChild(formCopy);

            // add submit and cancel buttons
            TodoList.eventListeners.addSubmitAndCancelButtons(modalCenter, formID, TodoList.updateSubtaskPath); 
        },
        clearModalCenter(modalCenter) {
            modalCenter.innerHTML= '';
        },
        makeFormWriteable(formCopy) {
            formCopy.querySelectorAll('input').forEach(input => {
                input.removeAttribute('readonly');
            });
        },
        addSubmitAndCancelButtons(modalCenter, formID, path) {
            const cancelButton = document.createElement('button');
            cancelButton.textContent = 'Cancel';
            cancelButton.addEventListener('click', (evt) => {
                TodoList.eventListeners.closeModalAndReset(evt, formID);
            });
            const submitButton = document.createElement('button');
            submitButton.textContent = 'Submit';
            submitButton.addEventListener('click', (evt) => {
                // TodoList.eventListeners.submitUpdatedTask(evt, formID);
                TodoList.eventListeners.submit(evt, formID, path);
                TodoList.eventListeners.closeModalAndReset(evt, formID);
            });
            modalCenter.appendChild(cancelButton);
            modalCenter.appendChild(submitButton);
        },
        async submit(evt, formID, path) {
            // for newly created tasks or subtasks there is no formID (or rather it should be null)
            const formName = `form${formID}`;
            const oldForm = evt.target.parentNode.querySelector('form');
            const newForm = new FormData(oldForm);
            const url = `${TodoList.origin}${path}`;

            const response = await fetch(url, {
                method: 'POST',
                body: newForm,
            });

            const result = await response.json();

            if (result.message === 'success') {
                // populate original form with new values if update succeeds
                const originalForm = document.forms[formName];
                
                for (const pair of newForm.entries()) {
                    originalForm.elements[pair[0]].value = pair[1];
                }
            } else {
                alert('Error: record not updated!');
            }
        },
        addTask(evt) {
            TodoList.eventListeners.openModal(evt);
            // // clear the modal
            // const modalCenter = evt.target.parentNode;
            // TodoList.eventListeners.clearModalCenter(modalCenter);

            // // copy the form, remove radio button, and clear inputs
            // const form = document.forms[0].cloneNode(false);
            // form.elements.radio.remove();
            // modalCenter.appendChild(form);

            // // add submit and cancel buttons with submit path
            // TodoList.eventListeners.addSubmitAndCancelButtons(modalCenter, null, TodoList.addTaskPath); 
        },
        addSubtask(evt) {
            // clear the modal
            const modalCenter = evt.target.parentNode;
            TodoList.eventListeners.clearModalCenter(modalCenter);

            // copy the form and remove radio button and plate_number input
            // change `id` to `parent_id`
            const form = document.forms[0].cloneNode(true);
            form.elements.radio.remove();
            form.elements.plate_number.remove();
            form.elements.id.setAttribute('name', 'parent_id');
            modalCenter.appendChild(form);

            // add submit and cancel buttons with submit path
            TodoList.eventListeners.addSubmitAndCancelButtons(modalCenter, null, TodoList.addSubtaskPath); 
        },
    },
    initialize() {
        this.setIncompleteTodosURL();
        this.setHomeURL();
        
        // bind Todolist to event handlers so that they can call other handlers
        // when invoked (otherwise `this` would reference the event target)
        for (let handler in this.eventListeners) {
            this.eventListeners[handler] = this.eventListeners[handler].bind(this);
        }
    },

    setIncompleteTodosURL() {
        this.incompleteTodosURL = `${this.origin}${this.dataPath}`;
    },

    setHomeURL() {
        this.homeURL = `${this.origin}${this.homePath}`;
    },

    async fetchAndDisplayList() {
        const response = await fetch(this.incompleteTodosURL);
        const result = await response.json();
        this.populateTaskList(result);
        this.addListToDOM(this.incompleteTasks);
        this.addNewTaskButton();
        this.addBackButton();
    },

    populateTaskList(result) {
        // add non-subtasks to incompleteTasks[]
        result.forEach(todo => {
            if (todo.subtask === '0') {
                this.incompleteTasks.push(todo);
            }
        });
        this.addSubtasks(result);
    },

    addSubtasks(result) {
        // filter out the subtasks
        const subtasks = result.filter(todo => todo.subtask === '1');
        
        // add all subtasks to appropriate todo.subtasks[] array
        this.incompleteTasks.forEach(todo => {
            todo.subtasks = subtasks.filter(subtask => subtask.parent_id === todo.id);
        });
    },

    addListToDOM(incompleteTasks) {
        const bodyFragment = new DocumentFragment();
        this.addHeader(incompleteTasks, bodyFragment);

        if (incompleteTasks.length > 0) {
            this.createList(incompleteTasks, bodyFragment);
        }

        document.body.appendChild(bodyFragment);
    },

    addNewTaskButton() {
        const button = document.createElement('button');
        button.textContent = 'Add Task';
        button.classList.add('addTaskButton');
        button.addEventListener('click', this.eventListeners.addTask);
        document.body.appendChild(button);
    },

    addBackButton() {
        const anchor = document.createElement('a');
        anchor.setAttribute('href', `${this.origin}${this.homePath}`);
        anchor.textContent = 'Main Page';
        anchor.classList.add('backButton')
        document.body.appendChild(anchor);
    },

    addHeader(incompleteTasks, bodyFragment) {
        const header = document.createElement('h2');
        header.classList.add('todoListHeader');
        
        if (incompleteTasks.length === 0) {
            header.textContent = 'Hooray! No tasks due!';
        } else {
            header.textContent = 'Todo List';
        }
        bodyFragment.appendChild(header);
    },

    createList(incompleteTasks, bodyFragment) {
        const todoList = document.createElement('ul');
        todoList.classList.add('todoList');

        const labelRow = this.createLabelRow();        
        todoList.appendChild(labelRow);

        incompleteTasks.forEach(todo => {
            const todoRow = this.createTodoRow(todo);
            todoList.appendChild(todoRow);
        });

        bodyFragment.appendChild(todoList);
    },

    createLabelRow() {
        const row = document.createElement('li');
        const spanContainer = document.createElement('div')
        spanContainer.id = 'spanContainer';

        const descriptionSpan =  document.createElement('span');
        descriptionSpan.textContent = 'Description';
        descriptionSpan.setAttribute('id', 'descriptionLabel');
        spanContainer.appendChild(descriptionSpan);

        const plateNumberSpan =  document.createElement('span');
        plateNumberSpan.textContent = 'Plate Number';
        plateNumberSpan.setAttribute('id', 'plateNumberLabel');
        spanContainer.appendChild(plateNumberSpan);
        
        const dateDueSpan =  document.createElement('span');
        dateDueSpan.textContent = 'Date Due';
        dateDueSpan.setAttribute('id', 'dateDueLabel');
        spanContainer.appendChild(dateDueSpan);
        
        const selectSpan =  document.createElement('span');
        selectSpan.textContent = 'Select';
        selectSpan.setAttribute('id', 'selectLabel');
        spanContainer.appendChild(selectSpan);
        
        row.appendChild(spanContainer);
        return row;
    },

    createTodoRow(todo) {
        const todoRow = document.createElement('li');
        const todoForm = document.createElement('form');
        todoForm.setAttribute('name', 'form' + todo.id); // allows us named access via document.forms
        todoForm.classList.add('todoForm');
        
        const hiddenIdInput = document.createElement('input');
        hiddenIdInput.value = todo.id;
        hiddenIdInput.setAttribute('readonly', true);
        hiddenIdInput.setAttribute('type', 'hidden');
        hiddenIdInput.setAttribute('name', 'id');
        todoForm.appendChild(hiddenIdInput);

        const descriptionInput = document.createElement('input');
        descriptionInput.classList.add('descriptionInput');
        descriptionInput.value = todo.description;
        descriptionInput.setAttribute('readonly', 'description');
        descriptionInput.setAttribute('name', 'description');
        todoForm.appendChild(descriptionInput);
        
        const plateNumberInput = document.createElement('input');
        plateNumberInput.classList.add('plateNumberInput');
        plateNumberInput.value = todo.plate_number;
        plateNumberInput.setAttribute('readonly', true);
        plateNumberInput.setAttribute('name', 'plate_number');
        todoForm.appendChild(plateNumberInput);
        
        const dateDueInput = document.createElement('input');
        dateDueInput.classList.add('dateDueInput');
        dateDueInput.value = todo.due_date;
        dateDueInput.setAttribute('readonly', true);
        dateDueInput.setAttribute('name', 'due_date');
        todoForm.appendChild(dateDueInput);
        
        const selectTaskInput = document.createElement('input');
        selectTaskInput.classList.add('selectTaskInput');
        selectTaskInput.setAttribute('type', 'radio');
        selectTaskInput.setAttribute('name', 'radio');
        selectTaskInput.addEventListener('input', this.eventListeners.openModal);
        todoForm.appendChild(selectTaskInput);

        todoRow.appendChild(todoForm);
        return todoRow;
    },
}

TodoList.initialize();
TodoList.fetchAndDisplayList();
// TodoList.eventListeners.openModal();

// const fragment = new DocumentFragment()
// const modal = document.createElement('div');
// modal.id = 'modal';
// fragment.appendChild(modal);
// document.body.appendChild(fragment);
// alert('cock');

// const currentURL = location.href;
//     const origin = new URL(currentURL).origin;
//     const incompleteTodosURL = `${origin}/Admin/Todos/getIncomplete`;

//     const incompleteTasks = [];
//     const todoList = document.querySelector('#todoList');
//     const listHeading = document.querySelector('#listHeading');
    
//     const addSubtaskList = (todo, li) => {
//         const ul = document.createElement('ul');

//         todo.subtasks.forEach(subtask => {
//             const li = document.createElement('li');
//             li.textContent = subtask.description;
//             ul.appendChild(li);
//         });

//         li.appendChild(ul);
//     };

//     const fillFragment = (fragment, todoList) => {
//         const ul = document.createElement('ul');
    
//         todoList.forEach(todo => {
//             const li = document.createElement('li');
//             li.textContent = todo.description;
//             ul.appendChild(li);
            
//             if (todo.subtasks.length > 0) {
//                 addSubtaskList(todo, li);
//             }
//         });

//         fragment.appendChild(ul);
//     };

//     const populateList = (todoList) => {
//         let fragment = document.createDocumentFragment();
//         fillFragment(fragment, todoList);
//         listHeading.after(fragment);
//     };

//     const displayList = (todoList) => {
//         if (todoList.length === 0) {
//             const noTodosMessage = document.createElement('h3');
//             noTodosMessage.textContent = "Hooray! No tasks due!";
//             listHeading.after(noTodosMessage);
//         } else {
//             populateList(todoList);
//         }
//     };

//     // get the incomplete Todos from db and then organize them together
//     // with any related subtasks

//     (async function() {
//         const response = await fetch(incompleteTodosURL)
//         const result = await response.json();
        
//         // add non-subtasks to incompleteTasks[]
//         result.forEach(todo => {
//             if (todo.subtask === '0') {
//                 incompleteTasks.push(todo);
//             }
//         });

//         // filter out the subtasks
//         const subtasks = result.filter(todo => todo.subtask === '1');
        
//         // add all subtasks to appropriate todo.subtasks[] array
//         incompleteTasks.forEach(todo => {
//             todo.subtasks = subtasks.filter(subtask => subtask.parent_id === todo.id);
//         });

//         incompleteTasks.forEach(todo => {
//             const li = document.createElement('li');
//             li.textContent = todo.description;
//             // todoList.appendChild(li);
//         });

//         displayList(incompleteTasks);
//     })();
  
