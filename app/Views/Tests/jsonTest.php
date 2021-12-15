<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Customer Info<?= $this->endSection() ?>

<?= $this->section("content") ?>



<div class="photoBox" data-image="unloaded">
    <img class="photoImage" src="<?= site_url("Admin/Customers/displayCustomerPhoto/" . $customer->passport) ?>">
    <div class="selectButton">Select</div> 
    <div class="deselectButton">De-select</div> 
    <!-- <label class="selectPhoto" for="passport">Select Photo</label>
    <input autocomplete="off" type="file" class="photoInput" id="passport" name="passport"> -->
</div>

<div class="photoBox" data-image="unloaded">
    <img class="photoImage" src="<?= site_url("Admin/Customers/displayCustomerPhoto/" . $customer->TRC_or_visa) ?>">
    <div class="selectButton">Select</div> 
    <div class="deselectButton">De-select</div> 
    <!-- <label class="selectPhoto" for="passport">Select Photo</label>
    <input autocomplete="off" type="file" class="photoInput" id="passport" name="passport"> -->
</div>

<div class="photoBox" data-image="unloaded">
    <img class="photoImage" src="<?= site_url("Admin/Customers/displayCustomerPhoto/" . $customer->passport) ?>">
    <div class="selectButton">Select</div> 
    <div class="deselectButton">De-select</div> 
    <!-- <label class="selectPhoto" for="passport">Select Photo</label>
    <input autocomplete="off" type="file" class="photoInput" id="passport" name="passport"> -->
</div>

<div class="photoBox" data-image="unloaded">
    <img class="photoImage" src="<?= site_url("Admin/Customers/displayCustomerPhoto/" . $customer->passport) ?>">
    <div class="selectButton">Select</div> 
    <div class="deselectButton">De-select</div> 
    <!-- <label class="selectPhoto" for="passport">Select Photo</label>
    <input autocomplete="off" type="file" class="photoInput" id="passport" name="passport"> -->
</div>

<div class="photoBox" data-image="unloaded">
    <img class="photoImage" src="<?= site_url("Admin/Customers/displayCustomerPhoto/" . $customer->passport) ?>">
    <div class="selectButton">Select</div> 
    <div class="deselectButton">De-select</div> 
    <!-- <label class="selectPhoto" for="passport">Select Photo</label>
    <input autocomplete="off" type="file" class="photoInput" id="passport" name="passport"> -->
</div>

<div class="photoBox" data-image="unloaded">
    <img class="photoImage" src="<?= site_url("Admin/Customers/displayCustomerPhoto/" . $customer->passport) ?>">
    <div class="selectButton">Select</div> 
    <div class="deselectButton">De-select</div> 
    <!-- <label class="selectPhoto" for="passport">Select Photo</label>
    <input autocomplete="off" type="file" class="photoInput" id="passport" name="passport"> -->
</div>

<div class="mailForm">

        <div class="customerSelect">
          <label for="names">Select Customer</label>  
          <select name="names" id="names">
          <option value=""></option>
          <?php foreach($customers as $customer): ?>
            <option value="<?= $customer->customer_name ?>"><?= $customer->customer_name ?></option>
          <?php endforeach; ?>
          </select>
        </div>
        <input type="email" class="email">
        <input type="textarea" class="messageBox">
        <div class="buttons">
            <button id="sendButton">Send</button>
            <button id="cancelButton">Cancel</button>
        </div>

</div>

    <script>

        // This section of code provides some functionality for our mailForm.
        // It fetches a JSON object with names and email addresses of current customers and adds an event listener to 
        // a select element in the form so we can simply select the name of a customer and automatically have their
        // email address added to the corresonding form input (for non-customers we can still manually enter the email address)

        let emailJSON;
        const mailForm = document.querySelector('.mailForm');
        const url = "<?= site_url('Test/jsonReturn'); ?>";
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

        // This section of code provides functionality for our selectButtons.
        // Pressing a button will add the corresponding photo's path to an array and make the mailForm visible

        let selected = [];
        const selectButtons = document.querySelectorAll('.selectButton');
        const deselectButtons = document.querySelectorAll('.deselectButton');
        
        // Hide the deselectButtons on page load
        window.addEventListener('load', function(e) {
            deselectButtons.forEach((button) => button.classList.add('hidden'));
        });

        // Clicking selectButton will hide it and show the deselectButton. The selected image will be darkened and
        // the mailForm will display. Finally, the corresponding photo's path will be added to selected[].
        // If selected.length > 4 all selectButtons are hidden
        selectButtons.forEach((button) => button.addEventListener('click', function(e) {
            mailForm.classList.remove('hidden');
            e.target.classList.add('hidden');
            e.target.nextElementSibling.classList.remove('hidden');
            e.target.previousElementSibling.style.filter = 'brightness(50%)';
            const path = e.target.previousElementSibling.src;
            const regEx = /(?<=o\/).*/i;
            const result = regEx.exec(path);
            selected.push(result[0]);

            if(selected.length > 4) {
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
            e.target.previousElementSibling.previousElementSibling.style.filter = 'brightness(100%)';
            const path = e.target.previousElementSibling.previousElementSibling.src;
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
        const photoImages = document.querySelectorAll('.photoImage');

        sendButton.addEventListener('click', function(e) {
            const formData = new FormData();
            formData.append('address', email.value);
            // Add a default message if the messageBox is empty
            formData.append('message', ((messageBox.value == '') ? 'Thanks for choosing Saigon Bike Rentals!' : messageBox.value));

            for (let index = 0; index < selected.length; index++) {
                formData.append(('path' + (index + 1)), selected[index]);
            }
            
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value)) {
                fetch("<?= site_url('Test/mailPhotos') ?>", {
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
        const cancelButton = document.querySelector('#cancelButton');
        
        cancelButton.addEventListener('click', function(e) {
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