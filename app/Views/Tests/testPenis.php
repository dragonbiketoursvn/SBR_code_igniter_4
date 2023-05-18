<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Test Penis<?= $this->endSection() ?>

<?= $this->section("content") ?>

<body>
    <div class="mailForm">

        <div class="customerSelect">
            <label for="names">Select Customer</label>
            <select name="names" id="names">
                <option value=""></option>
                <option value="Franken Penis">Franken Penis</option>
                <option value="Pussy Burger">Pussy Burger</option>
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
        const mailForm = document.querySelector(".mailForm");

        window.addEventListener('load', function(e) {
            // fetch(url).then((response) => response.json()).then(function(json) {
            //     emailJSON = json;
            // });
            mailForm.classList.add('hidden');
            email.value = '';
            nameInput.selectedIndex = 0;
            messageBox.value = '';
        });
    </script>
</body>

</html>