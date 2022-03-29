<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        #success {
            background-color: red;
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0px;
            z-index: 1;
        }
    </style>
</head>

<body>
    <input type="text" name="id" list="id-list" id="id">
    <input type="text" id="name">

    <datalist id="id">
        <?php foreach ($records as $record) : ?>
            <option value="<?= $record->id ?>">
            <?php endforeach; ?>
    </datalist>
    <button id="view">View Record</button>
    <button id="update">Update Record</button>

    <div id="success">
        <h1>SUCCESSFUL UPDATE!</h1>
    </div>

    <script>
        const view = document.querySelector('#view');
        const update = document.querySelector('#update');
        const id = document.querySelector('#id');
        const name = document.querySelector('#name');
        const success = document.querySelector('#success');

        window.addEventListener('load', function(evt) {
            id.value = '';
            name.style.display = 'none';
            update.style.display = 'none';
            success.style.display = 'none';
        });

        view.addEventListener('click', function(evt) {
            // Create FormData object and append value of id input
            const formData = new FormData();

            formData.append('id', id.value);

            fetch("<?= site_url('Test/returnRecord'); ?>", {
                method: 'POST',
                body: formData
            }).then(response => response.json()).then(function(json) {
                json.value = json.id;
                name.value = json.name;
                name.style.display = 'block';
                id.style.display = 'none';
                view.style.display = 'none';
                update.style.display = 'block';
            });
        });

        update.addEventListener('click', function(evt) {
            // Create FormData object and append value of id input
            const formData = new FormData();
            formData.append('name', name.value);
            formData.append('id', id.value);

            fetch("<?= site_url('Test/updateRecord'); ?>", {
                method: 'POST',
                body: formData
            }).then(response => response.json()).then(function(json) {
                name.value = json.name;
                id.value = json.id;
                name.style.display = 'block';
                id.style.display = 'none';
                view.style.display = 'block';
                update.style.display = 'none';
                success.style.display = 'block';

                setTimeout(function() {
                    success.style.display = 'none';
                }, 1000);
            });
        });
    </script>
</body>

</html>