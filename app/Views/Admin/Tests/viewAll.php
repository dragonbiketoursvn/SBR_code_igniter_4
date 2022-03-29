<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= site_url('css/photo-box.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Hairline&family=Bungee+Outline&family=Geo&family=Montserrat+Alternates:wght@100;400;700&family=Nova+Mono&family=Poppins:wght@500&family=Quantico&display=swap" rel="stylesheet">

    <style>
        .hidden {
            display: none;
        }

        .fade {
            animation: fade 1.5s linear 1 forwards;
        }

        @keyframes fade {
            0% {
                opacity: 100%;
            }

            100% {
                opacity: 0%;
            }
        }
    </style>

    <title>Test</title>
</head>

<body>

    <!-- This will be visible on page load -->
    <div id="view-start">
        <button id="get-all">View All</button>
        <button id="get-single">View Single</button>
        <button id="add-new">Add New</button>
    </div>

    <!-- This displays when we hit the View All button -->
    <div id="view-all">
        <div id="display-all-records">

        </div>
        <button class="previous-menu">Previous Menu</button>
    </div>


    <div id="view-search">
        <input type="text" id="search-box">
        <button id="get-record">Get Record</button>
        <!-- <button id="go-back">Go Back</button> -->
        <button class="previous-menu">Go Back</button>
    </div>

    <div id="view-add">
        <input type="text" name="text">
        <input type="text" name="moreText">

        <div class="photo-box new-record" data-image="unloaded">
            <img class="photo-image" src="">
            <div class="delete-button"><span>Delete</span></div>
            <div class="remove-button"><span>Remove</span></div>
            <div class="select-button"><span>Select</span></div>
            <div class="deselect-button"><span>De-select</span></div>
            <div class="place-holder"><i class="far fa-image"></i></div>
            <div class="select-photo-wrapper">
                <label class="select-photo" for="passport">
                    <i class="fas fa-camera"></i>
                    <span>Passport / Hộ Chiếu</span>
                </label>
                <input type="file" class="photo-input" id="passport" name="passport" accept="image/png, image/jpg">
            </div>
        </div>

        <div class="photo-box new-record" data-image="unloaded">
            <img class="photo-image" src="">
            <div class="delete-button"><span>Delete</span></div>
            <div class="remove-button"><span>Remove</span></div>
            <div class="select-button"><span>Select</span></div>
            <div class="deselect-button"><span>De-select</span></div>
            <div class="place-holder"><i class="far fa-image"></i></div>
            <div class="select-photo-wrapper">
                <label class="select-photo" for="nextPhoto">
                    <i class="fas fa-camera"></i>
                    <span>Next Photo</span>
                </label>
                <input type="file" class="photo-input" id="nextPhoto" name="nextPhoto" accept="image/png, image/jpg">
            </div>
        </div>

        <button id="add-record-button">Add Record</button>
        <button class="previous-menu">Previous Menu</button>

        <div id="spinner-container" class="hidden">
            <i id="spinner" class="fas fa-circle-notch fa-spin"></i>
            <i id="success" class="fas fa-check-circle"></i>
        </div>

    </div>

    <div id="view-edit">

        <input type="hidden" name="id">
        <input type="text" name="text" readonly>
        <input type="text" name="moreText" readonly>

        <div class="photo-box" data-image="unloaded">
            <img class="photo-image" src="">
            <div class="delete-button"><span>Delete</span></div>
            <div class="remove-button"><span>Remove</span></div>
            <div class="select-button"><span>Select</span></div>
            <div class="deselect-button"><span>De-select</span></div>
            <div class="place-holder"><i class="far fa-image"></i></div>
            <div class="select-photo-wrapper">
                <label class="select-photo" for="passport_edit">
                    <i class="fas fa-camera"></i>
                    <span>Passport / Hộ Chiếu</span>
                </label>
                <input type="file" class="photo-input" id="passport_edit" name="passport" accept="image/png, image/jpg">
            </div>
        </div>

        <div class="photo-box" data-image="unloaded">
            <img class="photo-image" src="">
            <div class="delete-button"><span>Delete</span></div>
            <div class="remove-button"><span>Remove</span></div>
            <div class="select-button"><span>Select</span></div>
            <div class="deselect-button"><span>De-select</span></div>
            <div class="place-holder"><i class="far fa-image"></i></div>
            <div class="select-photo-wrapper">
                <label class="select-photo" for="nextPhoto_edit">
                    <i class="fas fa-camera"></i>
                    <span>Next Photo</span>
                </label>
                <input type="file" class="photo-input" id="nextPhoto_edit" name="nextPhoto" accept="image/png, image/jpg">
            </div>
        </div>

        <button id="edit-button">Edit</button>
        <button class="previous-menu">Test Menu</button>
        <button id="update-button">Update</button>
        <button id="cancel-update-button">Cancel</button>
        <!-- This is the mailForm for sending photos from the page as attachments. In order to work as designed, the view needs 
        to receive $customers from the controller and we have to include the mailForm's js -->

        <div class="mailForm">
            <div class="customerSelect">
                <label for="mailForm-name-input">Select Customer</label>
                <select name="names" id="mailForm-name-input">
                    <option value=""></option>
                    <?php foreach ($customers as $customer) : ?>
                        <option value="<?= $customer->customer_name ?>"><?= $customer->customer_name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="email" class="mailForm-email-input">
            <input type="textarea" class="mailForm-messageBox">
            <div class="mailForm-buttons">
                <button id="mailForm-sendButton">Send</button>
                <button id="mailForm-cancelButton">Cancel</button>
            </div>
        </div>
    </div>

    <!-- our photoBox functionality -->
    <script src="<?= site_url('js/photoBox.js') ?>"></script>

    <script>
        /* GLOBALS */
        // Our views
        const viewStart = document.querySelector('#view-start');
        const viewAll = document.querySelector('#view-all');
        const viewSearch = document.querySelector('#view-search');
        const viewAdd = document.querySelector('#view-add');
        const viewEdit = document.querySelector('#view-edit');

        // Our buttons
        const editButton = document.querySelector('#edit-button');
        const updateButton = document.querySelector('#update-button');
        const cancelUpdateButton = document.querySelector('#cancel-update-button');
        // const getRecordButton = document.querySelector('#get-record');

        // buttons for the start menu
        const getAll = document.querySelector('#get-all');
        const getSingle = document.querySelector('#get-single');
        const addNew = document.querySelector('#add-new');

        // buttons for the other views
        const previousMenu = document.querySelectorAll('.previous-menu');

        // create a function to set up our initial view and call it
        const resetView = function() {
            viewAll.classList.add('hidden');
            viewSearch.classList.add('hidden');
            viewAdd.classList.add('hidden');
            viewStart.classList.remove('hidden');
            viewEdit.classList.add('hidden');
            viewEdit.querySelectorAll('.photo-box').forEach(photobox => {
                photobox.dataset.image = 'unloaded';
                photobox.querySelector('.photo-image').classList.add('hidden');
            });
        };

        resetView();

        // and a function to reset viewEdit
        const resetViewEdit = function() {
            updateButton.classList.add('hidden');
            cancelUpdateButton.classList.add('hidden');
            editButton.classList.remove('hidden');
            viewEdit.querySelector('.previous-menu').classList.remove('hidden');
            viewEdit.querySelectorAll('.delete-button').forEach(el => el.classList.add('hidden'));
            viewEdit.querySelectorAll('.select-button').forEach(el => {
                if (el.parentNode.dataset.image === 'loaded') {
                    el.classList.remove('hidden');
                }
            });
            viewEdit.querySelector('input[name="text"]').setAttribute('readonly', 'true');
            viewEdit.querySelector('input[name="moreText"]').setAttribute('readonly', 'true');
            viewEdit.querySelectorAll('.photo-image').forEach(img => {
                if (img.src.includes('data:')) {
                    img.src = '';
                    img.classList.add('hidden');
                    img.parentNode.dataset.image = 'unloaded';
                }
            });
            viewEdit.querySelectorAll('.photo-box').forEach(photobox => {
                photobox.dataset.editMode = 'off';
                if (photobox.dataset.image === 'unloaded') {
                    photobox.querySelector('.select-photo-wrapper').classList.add('hidden');
                    photobox.querySelector('.place-holder').classList.remove('hidden');
                    photobox.querySelector('.select-button').classList.add('hidden');
                }
            });
        };

        // display our other views when corresponding buttons are clicked
        getAll.addEventListener('click', (evt) => {
            viewStart.classList.add('hidden');
            viewAll.classList.remove('hidden');
        })

        getSingle.addEventListener('click', (evt) => {
            // Remember to unset input values before opening view!
            searchBox.value = '';
            searchBox.focus();
            viewStart.classList.add('hidden');
            viewSearch.classList.remove('hidden');
        })

        addNew.addEventListener('click', (evt) => {
            viewAdd.querySelectorAll('input').forEach(input => input.value = '');
            viewAdd.querySelectorAll('img').forEach(img => {
                img.src = ''
                img.classList.add('hidden');
            });
            viewAdd.querySelectorAll('.photo-box').forEach(box => box.dataset.image = 'unloaded');
            viewAdd.querySelectorAll('.remove-button').forEach(removebutton => removebutton.classList.add('hidden'));
            viewAdd.querySelectorAll('.select-photo-wrapper').forEach(removebutton => removebutton.classList.remove('hidden'));
            viewStart.classList.add('hidden');
            viewAdd.classList.remove('hidden');
        })

        // go back to our original view
        previousMenu.forEach((el) => {
            el.addEventListener('click', () => {
                resetView();
            })
        })

        /* || all functionality for viewAll */
        // get current records as json and use to populate displayAllRecords in viewAll
        let records = [];
        const displayAllRecords = document.querySelector('#display-all-records');

        // create an object to hold the current record to be displayed in full
        let currentRecord = {};

        const populateViewEdit = function() {
            viewEdit.querySelector('input[name="id"]').value = currentRecord.id;
            viewEdit.querySelector('input[name="text"]').value = currentRecord.text;
            viewEdit.querySelector('input[name="moreText"]').value = currentRecord.moreText;
            // viewEdit.querySelectorAll('.photo-image')[0].src = '';
            // viewEdit.querySelectorAll('.photo-image')[1].src = '';
            fetch(("http://sbr_code_igniter_4.localhost/Admin/Photos/displayPhoto/" + currentRecord.passport))
                .then(response => {
                    if (response.headers.get('Content-length') < 50) {
                        viewEdit.querySelectorAll('.photo-image')[0].src = '';
                    } else {
                        // return response.blob();
                        viewEdit.querySelectorAll('.photo-image')[0].src = currentRecord.passport ? ("http://sbr_code_igniter_4.localhost/Admin/Photos/displayPhoto/" + currentRecord.passport) : '';
                    }
                });
            // .then(blob => {
            //     if (typeof(blob) === 'object') {
            //         viewEdit.querySelectorAll('.photo-image')[0].src = URL.createObjectURL(blob);
            //     }
            // });
            // viewEdit.querySelectorAll('.photo-image')[0].src = currentRecord.passport ? ("http://sbr_code_igniter_4.localhost/Admin/Photos/displayPhoto/" + currentRecord.passport) : '';
            viewEdit.querySelectorAll('.photo-image')[1].src = currentRecord.nextPhoto ? ("http://sbr_code_igniter_4.localhost/Admin/Photos/displayPhoto/" + currentRecord.nextPhoto) : '';

        }

        // create a function expression to get current records
        const getCurrentRecords = function() {
            fetch('http://sbr_code_igniter_4.localhost/Admin/Tests/getRecords')
                .then(response => response.json())
                .then(json => {
                    // clear records[] of any content
                    records = [];
                    displayAllRecords.innerHTML = '';
                    console.log(records);
                    json.forEach(el => records.push(el));
                })
                .then(() => {
                    console.log(records);

                    records.forEach(el => {
                        let div = document.createElement('div');
                        let inputID = document.createElement('input');
                        let inputText = document.createElement('input');
                        let inputMoreText = document.createElement('input');
                        let profileButton = document.createElement('button');
                        profileButton.innerText = 'View Profile';
                        profileButton.addEventListener('click', evt => {
                            // hide viewAll
                            viewAll.classList.add('hidden');
                            // reset and unhide viewEdit
                            resetViewEdit();

                            // search records for the object with id property mathing inputID.value and assign to currentRecord
                            currentRecord = records.find(record => record.id === inputID.value);
                            populateViewEdit();

                            viewEdit.classList.remove('hidden')
                            // viewEdit.querySelector('input[name="text"]').value = currentRecord.text;
                            // viewEdit.querySelector('input[name="moreText"]').value = currentRecord.moreText;
                            // viewEdit.querySelectorAll('.photo-image')[0].src = currentRecord.passport ? ("http://sbr_code_igniter_4.localhost/Admin/Photos/displayPhoto/" + currentRecord.passport) : '';
                            // viewEdit.querySelectorAll('.photo-image')[1].src = currentRecord.nextPhoto ? ("http://sbr_code_igniter_4.localhost/Admin/Photos/displayPhoto/" + currentRecord.nextPhoto) : '';
                        });
                        inputID.value = el.id;
                        inputText.value = el.text;
                        inputMoreText.value = el.moreText;
                        displayAllRecords.appendChild(div);
                        div.appendChild(inputID);
                        div.appendChild(inputText);
                        div.appendChild(inputMoreText);
                        div.appendChild(profileButton);
                    })
                });
        }

        // and call it so viewAll is populated when the page loads
        getCurrentRecords();

        /* || viewEdit section */
        // hide the update and cancelButtons initially

        editButton.addEventListener('click', function(evt) {
            if (selected.length > 0) {
                alert('Cancel the mail form first');
            } else {
                photoBoxes.forEach(function(el) {
                    if (!el.classList.contains('new-record')) {

                        // set a data-attribute to show we're now in edit mode
                        el.dataset.editMode = 'on';

                        // Create consts for the components to be shown or hidden initially
                        const selectPhoto = el.querySelector('.select-photo-wrapper');
                        const photoImage = el.querySelector('.photo-image');
                        const deleteButton = el.querySelector('.delete-button');
                        const placeHolder = el.querySelector('.place-holder');
                        // const photoInput = el.querySelector('.photo-input');
                        // const removeButton = el.querySelector('.remove-button');
                        const selectButton = el.querySelector('.select-button');
                        // const deselectButton = el.querySelector('.deselect-button');

                        selectButton.classList.add('hidden');

                        if (selected.length > 0) {
                            alert('penis');
                        }

                        if (el.dataset.image !== 'loaded') {
                            placeHolder.classList.add('hidden');
                            selectPhoto.classList.remove('hidden');
                        } else {
                            deleteButton.classList.remove('hidden');
                        }
                    }
                });

                // remove readonly attribute from the text inputs
                viewEdit.querySelector('input[name="text"]').removeAttribute('readonly');
                viewEdit.querySelector('input[name="moreText"]').removeAttribute('readonly');

                // hide editButton and back button, show updateButton and cancelUpdateButton
                editButton.classList.add('hidden');
                viewEdit.querySelector('.previous-menu').classList.add('hidden');
                updateButton.classList.remove('hidden');
                cancelUpdateButton.classList.remove('hidden');
            }
        })

        // set cancelUpdateButton to reset viewEdit 
        cancelUpdateButton.addEventListener('click', () => {
            resetViewEdit();
        })

        // set updateButton to send current input values to server
        updateButton.addEventListener('click', (evt) => {

            const viewEdit = document.querySelector('#view-edit');
            const inputID = viewEdit.querySelector('input[name="id"]');
            const text = viewEdit.querySelector('input[name="text"]');
            const moreText = viewEdit.querySelector('input[name="moreText"]');
            const passport = viewEdit.querySelector('input[name="passport"]');
            const nextPhoto = viewEdit.querySelector('input[name="nextPhoto"]');

            const formData = new FormData();
            formData.append('id', inputID.value);
            formData.append('text', text.value);
            formData.append('moreText', moreText.value);

            if (passport.value) {
                formData.append('passport', passport.files[0]);
            }

            if (nextPhoto.value) {
                formData.append('nextPhoto', nextPhoto.files[0]);
            }

            // if the record is successfully updated we alert a success message, reset and update currentRecords,
            // clear the inputs, and hide the removeButton. Since we're sending async requests to the server we need 
            // to make sure that we don't get records until after the update has completed and we don't update currentRecord
            // until after the second request has completed.
            fetch("http://sbr_code_igniter_4.localhost/Admin/Tests/asyncSubmit", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(message => {
                    alert(message);
                    // getCurrentRecords();

                    // currentRecord = records.find(record => record.id === inputID.value);
                    // currentRecord = records[0];
                    // console.log(records);

                    // resetViewEdit();
                    // populateViewEdit();
                    // text.value = '';
                    // moreText.value = '';
                    // passport.value = '';
                    // nextPhoto.value = '';
                    // document.querySelectorAll('.new-record').forEach(el => {
                    //     el.querySelectorAll('.photo-image').forEach(photoImage => {
                    //         photoImage.src = '';
                    //     })
                    //     el.querySelector('.remove-button').classList.add('hidden');
                    //     el.querySelector('.select-photo-wrapper').classList.remove('hidden');
                    // })
                })
                .then(() => {
                    console.log('subsequent then block finished');
                    return fetch('http://sbr_code_igniter_4.localhost/Admin/Tests/getRecords');
                })
                .then(response => response.json())
                .then(json => {
                    // clear records[] of any content
                    records = [];
                    displayAllRecords.innerHTML = '';
                    json.forEach(el => records.push(el));
                })
                .then(() => {
                    currentRecord = records.find(record => record.id === inputID.value);
                    // create and populate all the records for viewAll
                    records.forEach(el => {
                        let div = document.createElement('div');
                        let inputID = document.createElement('input');
                        let inputText = document.createElement('input');
                        let inputMoreText = document.createElement('input');
                        let profileButton = document.createElement('button');
                        profileButton.innerText = 'View Profile';
                        profileButton.addEventListener('click', evt => {
                            // hide viewAll
                            viewAll.classList.add('hidden');
                            // reset and unhide viewEdit
                            resetViewEdit();

                            // search records for the object with id property mathing inputID.value and assign to currentRecord
                            currentRecord = records.find(record => record.id === inputID.value);
                            populateViewEdit();

                            viewEdit.classList.remove('hidden')
                            // viewEdit.querySelector('input[name="text"]').value = currentRecord.text;
                            // viewEdit.querySelector('input[name="moreText"]').value = currentRecord.moreText;
                            // viewEdit.querySelectorAll('.photo-image')[0].src = currentRecord.passport ? ("http://sbr_code_igniter_4.localhost/Admin/Photos/displayPhoto/" + currentRecord.passport) : '';
                            // viewEdit.querySelectorAll('.photo-image')[1].src = currentRecord.nextPhoto ? ("http://sbr_code_igniter_4.localhost/Admin/Photos/displayPhoto/" + currentRecord.nextPhoto) : '';
                        });
                        inputID.value = el.id;
                        inputText.value = el.text;
                        inputMoreText.value = el.moreText;
                        displayAllRecords.appendChild(div);
                        div.appendChild(inputID);
                        div.appendChild(inputText);
                        div.appendChild(inputMoreText);
                        div.appendChild(profileButton);
                    })
                })
                .then(() => {
                    console.log(records);
                    console.log(currentRecord);
                    resetViewEdit();
                    populateViewEdit();
                })
                .catch(error => console.log(error));
        });

        /* || viewSearch section */
        // functionality to find record by id and display profile
        const searchBox = viewSearch.querySelector('#search-box');
        const getRecordButton = viewSearch.querySelector('#get-record');

        getRecordButton.addEventListener('click', () => {
            currentRecord = records.find(record => record.id === searchBox.value);
            viewSearch.classList.add('hidden');
            populateViewEdit();
            // resetViewEdit();
            // viewEdit.querySelector('input[name="text"]').value = currentRecord.text;
            // viewEdit.querySelector('input[name="moreText"]').value = currentRecord.moreText;
            // viewEdit.querySelectorAll('.photo-image')[0].src = currentRecord.passport ? ("http://sbr_code_igniter_4.localhost/Admin/Photos/displayPhoto/" + currentRecord.passport) : '';
            // viewEdit.querySelectorAll('.photo-image')[1].src = currentRecord.nextPhoto ? ("http://sbr_code_igniter_4.localhost/Admin/Photos/displayPhoto/" + currentRecord.nextPhoto) : '';

            viewEdit.classList.remove('hidden');
        });

        /* || addRecordButton */
        // add new record from viewAdd 
        const addRecordButton = document.querySelector('#add-record-button');

        addRecordButton.addEventListener('click', (evt) => {

            const spinnerContainer = document.querySelector('#spinner-container');
            const spinner = document.querySelector('#spinner');
            const success = document.querySelector('#success');

            success.classList.add('hidden');
            spinnerContainer.classList.remove('hidden');

            const viewAdd = document.querySelector('#view-add');
            const text = viewAdd.querySelector('input[name="text"]');
            const moreText = viewAdd.querySelector('input[name="moreText"]');
            const passport = viewAdd.querySelector('input[name="passport"]');
            const nextPhoto = viewAdd.querySelector('input[name="nextPhoto"]');

            const formData = new FormData();
            formData.append('text', text.value);
            formData.append('moreText', moreText.value);
            formData.append('passport', passport.files[0]);
            formData.append('nextPhoto', nextPhoto.files[0]);

            // if the record is successfully added to the db we alert a success message, reset and update currentRecords
            // , clear the inputs, and hide the removeButton
            fetch("http://sbr_code_igniter_4.localhost/Admin/Tests/asyncSubmit", {
                method: 'POST',
                body: formData
            }).then(response => response.json().then(json => {
                let message = '';
                for (prop in json) {
                    message = message + json[prop] + "\n";
                }
                if (message !== 'Success!\n') {
                    alert(message);
                } else {
                    console.log(message);
                }
                // spinnerContainer.classList.add('hidden');
                spinner.classList.add('hidden');
                success.classList.remove('hidden');
                success.classList.add('fade');
                // records = [];
                getCurrentRecords();
                text.value = '';
                moreText.value = '';
                passport.value = '';
                nextPhoto.value = '';
                document.querySelectorAll('.new-record').forEach(el => {
                    el.parentNode.dataset.image = 'unloaded';
                    el.querySelectorAll('.photo-image').forEach(photoImage => {
                        photoImage.src = '';
                        photoImage.classList.add('hidden');
                    })
                    el.querySelector('.remove-button').classList.add('hidden');
                    el.querySelector('.select-photo-wrapper').classList.remove('hidden');
                })
            }).catch(error => console.log(error)));
        })
    </script>

</body>

</html>