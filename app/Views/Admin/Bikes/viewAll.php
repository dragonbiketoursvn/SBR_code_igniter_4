<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>View All Photos<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div id="filterBar">
    <select name="brand" id="brand" class="filter">
        <option value="ALL">ALL</option>
        <?php foreach ($brands as $brand) : ?>
            <option value="<?= $brand->brand ?>"><?= $brand->brand ?></option>
        <?php endforeach; ?>
    </select>
    <select name="model" id="model" class="filter">
        <option value="ALL">ALL</option>
        <?php foreach ($models as $model) : ?>
            <option value="<?= $model->model ?>"><?= $model->model ?></option>
        <?php endforeach; ?>
    </select>
    <select name="year" id="year" class="filter">
        <option value="ALL">ALL</option>
    </select>
    <select name="plateNumber" id="plateNumber" class="filter">
        <option value="ALL">ALL</option>
        <?php foreach ($bikes as $bike) : ?>
            <option value="<?= $bike->plate_number ?>"><?= $bike->plate_number ?></option>
        <?php endforeach; ?>
    </select>
    <button id="removeFilters">
        REMOVE FILTERS
    </button>
</div>

<div id="filterBarSpacer"></div>

<?php foreach ($bikes as $bike) : ?>
    <div class="photoSection" data-brand="<?= $bike->brand ?>" data-model="<?= $bike->model ?>" data-year="<?= $bike->year ?>" data-plate_number="<?= $bike->plate_number ?>">
        <div class="photoBox" data-image="unloaded">
            <div class="photoCaption"><?= $bike->plate_number . ' (side)' ?></div>
            <img class="photoImage" src="<?= site_url('Admin/Bikes/displayPhoto/') . $bike->pic_side ?>">
            <div class="selectButton">Select</div>
            <div class="deselectButton">De-select</div>
        </div>

        <div class="photoBox" data-image="unloaded">
            <div class="photoCaption"><?= $bike->plate_number . ' (front)' ?></div>
            <img class="photoImage" src="<?= site_url('Admin/Bikes/displayPhoto/') . $bike->pic_front ?>">
            <div class="selectButton">Select</div>
            <div class="deselectButton">De-select</div>
        </div>

        <div class="photoBox" data-image="unloaded">
            <div class="photoCaption"><?= $bike->plate_number . ' (rear)' ?></div>
            <img class="photoImage" src="<?= site_url('Admin/Bikes/displayPhoto/') . $bike->pic_rear ?>">
            <div class="selectButton">Select</div>
            <div class="deselectButton">De-select</div>
        </div>

        <div class="photoBox" data-image="unloaded">
            <div class="photoCaption"><?= $bike->plate_number . ' (trunk)' ?></div>
            <img class="photoImage" src="<?= site_url('Admin/Bikes/displayPhoto/') . $bike->pic_trunk ?>">
            <div class="selectButton">Select</div>
            <div class="deselectButton">De-select</div>
        </div>
    </div>
<?php endforeach; ?>

<div class="mailForm">

    <div class="customerSelect">
        <label for="names">Select Customer</label>
        <select name="names" id="names">
            <option value=""></option>
            <?php foreach ($customers as $customer) : ?>
                <option value="<?= $customer->customer_name ?>"><?= $customer->customer_name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <input type="email" class="email">
    <input type="textarea" class="messageBox">
    <div class="buttons">
        <button id="sendButton">Send</button>
        <button id="mailCancelButton">Cancel</button>
    </div>

</div>

<script>
    /* This section is for our filterBar */

    const filterBar = document.querySelector('#filterBar');
    const brand = document.querySelector('#brand');
    const model = document.querySelector('#model');
    const year = document.querySelector('#year');
    const plateNumber = document.querySelector('#plateNumber');
    const photoSections = document.querySelectorAll('.photoSection');
    const selectors = document.querySelectorAll('.filter');
    const currentFilters = {
        brand: 'ALL',
        model: 'ALL',
        year: 'ALL',
        plateNumber: 'ALL'
    };
    const removeFilters = document.querySelector('#removeFilters');
    // Hide removeFilters until some filters have been applied
    window.addEventListener('load', () => removeFilters.classList.add('hidden'));

    // Dynamically generate options for year select menu (so current year is always at top)
    const currentYear = new Date().getFullYear();

    for (let i = 0; i < 20; i++) {
        let yearOption = document.createElement('option');
        yearOption.value = yearOption.innerHTML = currentYear - i;
        year.appendChild(yearOption);
    }

    // Now add filtering functionality. Update currentFilters each time a change event fires and then re-filter
    // the photoSections based on the new values of currentFilters
    selectors.forEach(function(el) {
        el.addEventListener('change', function(evt) {
            currentFilters[el.id] = evt.target.value;
            removeFilters.classList.remove('hidden');

            photoSections.forEach(function(element) {
                if ((currentFilters.brand !== 'ALL') && (currentFilters.brand !== element.dataset.brand)) {
                    element.classList.add('hidden');
                } else if ((currentFilters.model !== 'ALL') && (currentFilters.model !== element.dataset.model)) {
                    element.classList.add('hidden');
                } else if ((currentFilters.year !== 'ALL') && (currentFilters.year !== element.dataset.year)) {
                    element.classList.add('hidden');
                } else if ((currentFilters.plateNumber !== 'ALL') && (currentFilters.plateNumber !== element.dataset.plate_number)) {
                    element.classList.add('hidden');
                } else {
                    element.classList.remove('hidden');
                }
            })

            /* Update the select elements so options only appear for bikes which haven't already been hidden */
            // Start by removing all options from the select elements
            selectors.forEach(el => el.innerHTML = '');

            // Then for each filter category we create an array to hold all currently visible brands plus 'All', get rid of all 
            // duplicates, and order alphabetically   
            const brands = [];
            photoSections.forEach(function(el) {
                if (!el.classList.contains('hidden')) {
                    brands.push(el.dataset.brand);
                }
            });
            const uniqueBrands = [];
            const setBrands = new Set(brands);
            setBrands.forEach(el => uniqueBrands.push(el));
            uniqueBrands.sort();
            if (evt.target.name !== 'brand' && uniqueBrands.length > 1) {
                uniqueBrands.unshift('ALL');
            }
            uniqueBrands.forEach(function(el) {
                let option = document.createElement('option');
                option.textContent = el;
                option.value = el;
                brand.appendChild(option);
            });


            const models = [];
            photoSections.forEach(function(el) {
                if (!el.classList.contains('hidden')) {
                    models.push(el.dataset.model);
                }
            });
            const uniqueModels = [];
            const setModels = new Set(models);
            setModels.forEach(el => uniqueModels.push(el));
            uniqueModels.sort();
            if (evt.target.name !== 'model' && uniqueModels.length > 1) {
                uniqueModels.unshift('ALL');
            }
            uniqueModels.forEach(function(el) {
                let option = document.createElement('option');
                option.textContent = el;
                option.value = el;
                model.appendChild(option);
            });


            const years = [];
            photoSections.forEach(function(el) {
                if (!el.classList.contains('hidden')) {
                    years.push(el.dataset.year);
                }
            });
            const uniqueYears = [];
            const setYears = new Set(years);
            setYears.forEach(el => uniqueYears.push(el));
            uniqueYears.sort();
            if (evt.target.name !== 'year' && uniqueYears.length > 1) {
                uniqueYears.unshift('ALL');
            }
            uniqueYears.forEach(function(el) {
                let option = document.createElement('option');
                option.textContent = el;
                option.value = el;
                year.appendChild(option);
            });


            const plateNumbers = [];
            photoSections.forEach(function(el) {
                if (!el.classList.contains('hidden')) {
                    plateNumbers.push(el.dataset.plate_number);
                }
            });
            const uniquePlateNumbers = [];
            const setPlateNumbers = new Set(plateNumbers);
            setPlateNumbers.forEach(el => uniquePlateNumbers.push(el));
            uniquePlateNumbers.sort();
            if (evt.target.name !== 'plate_number' && uniquePlateNumbers.length > 1) {
                uniquePlateNumbers.unshift('ALL');
            }
            uniquePlateNumbers.forEach(function(el) {
                let option = document.createElement('option');
                option.textContent = el;
                option.value = el;
                plateNumber.appendChild(option);
            });
        })
    })

    removeFilters.addEventListener('click', function(evt) {

        evt.target.classList.add('hidden');
        photoSections.forEach(el => el.classList.remove('hidden'));

        /* Update the select elements */
        // Start by removing all options from the select elements
        selectors.forEach(el => el.innerHTML = '');
        for (prop in currentFilters) {
            currentFilters[prop] = 'ALL';
        }

        // Then for each filter category we create an array to hold all currently visible brands plus 'All', get rid of all 
        // duplicates, and order alphabetically   
        const brands = [];
        photoSections.forEach(function(el) {
            brands.push(el.dataset.brand);
        });
        const uniqueBrands = [];
        const setBrands = new Set(brands);
        setBrands.forEach(el => uniqueBrands.push(el));
        uniqueBrands.sort();
        uniqueBrands.unshift('ALL');
        uniqueBrands.forEach(function(el) {
            let option = document.createElement('option');
            option.textContent = el;
            option.value = el;
            brand.appendChild(option);
        });

        const models = [];
        photoSections.forEach(function(el) {
            models.push(el.dataset.model);
        });
        const uniqueModels = [];
        const setModels = new Set(models);
        setModels.forEach(el => uniqueModels.push(el));
        uniqueModels.sort();
        uniqueModels.unshift('ALL');
        uniqueModels.forEach(function(el) {
            let option = document.createElement('option');
            option.textContent = el;
            option.value = el;
            model.appendChild(option);
        });


        const years = [];
        photoSections.forEach(function(el) {
            years.push(el.dataset.year);
        });
        const uniqueYears = [];
        const setYears = new Set(years);
        setYears.forEach(el => uniqueYears.push(el));
        uniqueYears.sort();
        uniqueYears.unshift('ALL');
        uniqueYears.forEach(function(el) {
            let option = document.createElement('option');
            option.textContent = el;
            option.value = el;
            year.appendChild(option);
        });


        const plateNumbers = [];
        photoSections.forEach(function(el) {
            plateNumbers.push(el.dataset.plate_number);
        });
        const uniquePlateNumbers = [];
        const setPlateNumbers = new Set(plateNumbers);
        setPlateNumbers.forEach(el => uniquePlateNumbers.push(el));
        uniquePlateNumbers.sort();
        uniquePlateNumbers.unshift('ALL');
        console.log(uniquePlateNumbers);
        uniquePlateNumbers.forEach(function(el) {
            let option = document.createElement('option');
            option.textContent = el;
            option.value = el;
            plateNumber.appendChild(option);
        });
    });

    /* This section is for our photoBox functionality: display, delete, upload */

    // Create consts for the UNIQUE individual page elements plus consts for the other elements taken as UNIQUE groups.
    // This is necessary so that we can set event listeners that will change the state of individual components while leaving
    // other, identical components unaffected.

    const photoBoxes = document.querySelectorAll('.photoBox'); // boxes for displaying/editing photos associated with record
    const photoCaptions = document.querySelectorAll('.photoCaption'); // captions for each photo
    const photoImages = document.querySelectorAll('.photoImage'); // the img elements in each photoBox
    // const photoInputs = document.querySelectorAll('.photoInput'); // photo inputs remain hidden

    // For each photoImage that loads set its photoBox's data-image attribute to "loaded" (default is "unloaded")
    photoImages.forEach(function(e) {
        e.addEventListener('load', function() {
            e.parentNode.dataset.image = "loaded";
        });
    });


    // This section of code provides some functionality for our mailForm.
    // It fetches a JSON object with names and email addresses of current customers and adds an event listener to 
    // a select element in the form so we can simply select the name of a customer and automatically have their
    // email address added to the corresonding form input (for non-customers we can still manually enter the email address)

    let emailJSON;
    const mailForm = document.querySelector('.mailForm');
    const url = "http://sbr_code_igniter_4.localhost/Admin/Customers/emailsAsJSON";
    const email = document.querySelector('.email');
    const nameInput = document.querySelector('#names');
    const messageBox = document.querySelector('.messageBox');

    window.addEventListener('load', function(e) {
        fetch(url).then((response) => response.json()).then(function(json) {
            emailJSON = json;
        });
        mailForm.classList.add('hidden');
        email.value = '';
        nameInput.selectedIndex = 0;
        messageBox.value = '';
    });

    nameInput.addEventListener('change', function(e) {
        const name = nameInput.value;
        email.value = emailJSON[name] ?? '';
    });

    // This section of code provides functionality for our selectButtons and mailForm.
    // Pressing a button will add the corresponding photo's path to an array and make the mailForm visible
    let selected = [];
    const selectButtons = document.querySelectorAll('.selectButton');
    const deselectButtons = document.querySelectorAll('.deselectButton');

    window.addEventListener('load', function(evt) {
        selectors.forEach((el) => el.value = 'ALL');

        deselectButtons.forEach((e) => e.classList.add('hidden'));
        mailForm.classList.add('hidden');
        selectButtons.forEach(function(el) {
            if (el.parentNode.dataset.image !== 'loaded') {
                el.classList.add('hidden');
            }
        });

        // photoInputs.forEach((e) => e.classList.add('hidden')); // hide each of the photo inputs
        // photoImages.forEach((e) => e.classList.add('hidden')); // hide the img elements since they're empty
        // But have them display when an image has loaded
        photoImages.forEach(function(el) {
            if (el.parentNode.dataset.image !== 'loaded') {
                el.classList.add('hidden');
            }
        });
    })

    // Clicking selectButton will hide it and show the deselectButton. The selected image will be darkened and
    // the mailForm will display. Finally, the corresponding photo's path will be added to selected[].
    // If selected.length > 4 all selectButtons are hidden
    selectButtons.forEach((button) => button.addEventListener('click', function(e) {
        mailForm.classList.remove('hidden');
        e.target.classList.add('hidden');
        e.target.nextElementSibling.classList.remove('hidden');
        e.target.parentNode.querySelector('img').style.filter = 'brightness(50%)';
        const path = e.target.parentNode.querySelector('img').src;
        const regEx = /(?<=o\/).*/i;
        const result = regEx.exec(path);
        selected.push(result[0]);

        if (selected.length > 4) {
            selectButtons.forEach((button) => button.classList.add('hidden'));
        }
    }));

    // Clicking deselectButton will hide it and show the selectButton. The selected image will have its normal
    // brightness restored and the corresponding photo's path will be removed from selected[].
    // The mailForm will be hidden if selected.length < 1.
    // If selected.length < 5 any selectButtons whose sibling deleteButtons are hidden will be unhidden

    deselectButtons.forEach((button) => button.addEventListener('click', function(e) {
        e.target.classList.add('hidden');
        e.target.previousElementSibling.classList.remove('hidden');
        e.target.parentNode.querySelector('img').style.filter = 'brightness(100%)';
        const path = e.target.parentNode.querySelector('img').src;
        const regEx = /(?<=o\/).*/i;
        const result = regEx.exec(path);

        selected = selected.filter(function(element) {
            return element !== result[0];
        });

        if (selected.length < 1) {
            mailForm.classList.add('hidden');
        }

        if (selected.length < 5) {
            selectButtons.forEach(function(e) {
                if (e.nextElementSibling.classList.contains('hidden')) {
                    e.classList.remove('hidden');
                }
            })
        }

    }));

    // Create a const for our sendButton and give it a click event listener that will:
    // put the email address, message, and paths of selected photos into a FormData object,
    // send our FormData object as the body of an async POST request to the controller which actually mails everything,
    // and finally return everything to its original state
    const sendButton = document.querySelector('#sendButton');

    sendButton.addEventListener('click', function(e) {
        const formData = new FormData();
        formData.append('address', email.value);
        // Add a default message if the messageBox is empty
        formData.append('message', ((messageBox.value == '') ? 'Thanks for choosing Saigon Bike Rentals!' : messageBox.value));

        for (let index = 0; index < selected.length; index++) {
            formData.append(('path' + (index + 1)), selected[index]);
        }

        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value)) {
            fetch("http://sbr_code_igniter_4.localhost/Admin/Bikes/mailPhotos", {
                method: 'POST',
                body: formData
            }).then(response => response.text().then(text => alert(text)).catch(error => console.log(error)));

            selected = [];
            selectButtons.forEach(e => e.classList.remove('hidden'));
            deselectButtons.forEach(e => e.classList.add('hidden'));
            email.value = '';
            messageBox.value = '';
            nameInput.selectedIndex = 0;
            mailForm.classList.add('hidden');
            photoImages.forEach(e => e.style.filter = 'brightness(100%)');
        } else {
            alert('Please enter a valid email address');
        }
    });

    // And lastly our cancelButton will do everything the sendButton does except the send part
    const mailCancelButton = document.querySelector('#mailCancelButton');

    mailCancelButton.addEventListener('click', function(e) {
        selected = [];
        selectButtons.forEach(e => e.classList.remove('hidden'));
        deselectButtons.forEach(e => e.classList.add('hidden'));
        email.value = '';
        messageBox.value = '';
        nameInput.selectedIndex = 0;
        mailForm.classList.add('hidden');
        photoImages.forEach(e => e.style.filter = 'brightness(100%)');

    });
</script>

<?= $this->endSection() ?>