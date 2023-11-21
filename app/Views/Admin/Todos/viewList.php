<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        html,
        body {
        margin: 0px;
        height: 100%;
        }

        .taskList {
            padding: 0;
        }

        .taskForm {
            display: flex;
            flex-direction: row;
            /* border: 2px solid green; */
        }

        input {
            /* border: none; */
        }

        .descriptionInput {
            flex: 6;
        }

        .plateNumberInput {
            flex: 2;
        }

        .dateDueInput {
            flex: 2;
        }

        .selectCurrentFormInput {
            flex: 1;
        }

        .backToMain {
            display: flex;
            width: 100%;
            height: 5em;
            background-color: green;
            color: #eeeeee;
            font-size: 2em;
            text-decoration: none;
            align-items: center;
            justify-content: space-around;
        }

        li {
            list-style-type: none;
        }

        span {
            /* border: 2px solid red; */
            text-align: center;
        }

        #spanContainer {
            display: flex;
        }

        #descriptionLabel {
            flex: 6;
        }

        #plateNumberLabel {
            flex: 2;
        }

        #dateDueLabel {
            flex: 2;
        }

        #selectLabel {
            flex: 1;
        }

        #modal {
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 10;
            position: fixed;
            top: 0;
            /* opacity: 40%; */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #modalCenter {
            height: 50%;
            width: 50%;
            background: #0F06DB;
            opacity: 100%;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
        }

        #markDoneButton,
        #addSubtaskButton,
        #editButton {
            width: 70%;
            height: 25%;
        }

        .updateForm {
            height: 100%;
            width: 100%;
            padding: 0;
            /* background: #0F06DB;
            opacity: 100%; */
            border-radius: 10px;
            border: 2px solid red;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
        }

        .updateForm input {
            width: 90%;
        }

    </style>
    <title>Todo List</title>
     <!-- <a class="backToMain" href="<?= site_url('Admin/Home') ?>">Main Menu</a> -->
</head>
<body>

</body>

<script>
    // const currentURL = location.href;
    // const origin = new URL(currentURL).origin;
    // const incompleteTodosURL = `${origin}/Admin/Todos/getIncomplete`;
    // const incompleteTasks = [];
    // const todoList = document.querySelector('#todoList');
    // const listHeading = document.querySelector('#listHeading');
    
    // const addSubtaskList = (todo, li) => {
    //     const ul = document.createElement('ul');

    //     todo.subtasks.forEach(subtask => {
    //         const li = document.createElement('li');
    //         li.textContent = subtask.description;
    //         ul.appendChild(li);
    //     });

    //     li.appendChild(ul);
    // };

    // const fillFragment = (fragment, todoList) => {
    //     const ul = document.createElement('ul');
    
    //     todoList.forEach(todo => {
    //         const li = document.createElement('li');
    //         li.textContent = todo.description;
    //         ul.appendChild(li);
            
    //         if (todo.subtasks.length > 0) {
    //             addSubtaskList(todo, li);
    //         }
    //     });

    //     fragment.appendChild(ul);
    // };

    // const populateList = (todoList) => {
    //     let fragment = document.createDocumentFragment();
    //     fillFragment(fragment, todoList);
    //     listHeading.after(fragment);
    // };

    // const displayList = (todoList) => {
    //     if (todoList.length === 0) {
    //         const noTodosMessage = document.createElement('h3');
    //         noTodosMessage.textContent = "Hooray! No tasks due!";
    //         listHeading.after(noTodosMessage);
    //     } else {
    //         populateList(todoList);
    //     }
    // };

    // // get the incomplete Todos from db and then organize them together
    // // with any related subtasks

    // (async function() {
    //     const response = await fetch(incompleteTodosURL)
    //     const result = await response.json();
        
    //     // add non-subtasks to incompleteTasks[]
    //     result.forEach(todo => {
    //         if (todo.subtask === '0') {
    //             incompleteTasks.push(todo);
    //         }
    //     });

    //     // filter out the subtasks
    //     const subtasks = result.filter(todo => todo.subtask === '1');
        
    //     // add all subtasks to appropriate todo.subtasks[] array
    //     incompleteTasks.forEach(todo => {
    //         todo.subtasks = subtasks.filter(subtask => subtask.parent_id === todo.id);
    //     });

    //     incompleteTasks.forEach(todo => {
    //         const li = document.createElement('li');
    //         li.textContent = todo.description;
    //         // todoList.appendChild(li);
    //     });

    //     displayList(incompleteTasks);
    // })();

</script>

<!-- <script src="<?= site_url('js/TodoList/todos.js') ?>"></script> -->
<script type="module" src="<?= site_url('js/TodoList/todosTest.js') ?>"></script>

</html> 