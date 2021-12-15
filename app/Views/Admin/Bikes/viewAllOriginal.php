<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bike Photos</title>
    <link rel="stylesheet" href="<?= site_url('css/photo-containers.css') ?>">
    <style>
        body {
            padding-top: 35px;
        }
    </style>
</head>
<body>
    <div id="filterBar">
        <select name="brand" id="brand">
            <option value="HONDA">HONDA</option>
            <option value="YAMAHA">YAMAHA</option>
            <option value="SYM">SYM</option>
        </select>
        <select name="model" id="model">
            <?php foreach($models as $model): ?>
                <option value="<?= $model->model ?>"><?= $model->model ?></option>
            <?php endforeach; ?>
        </select>
        <select name="year" id="year"></select>
        <select name="plateNumber" id="plateNumber">
        <?php foreach($bikes as $bike): ?>
                <option value="<?= $bike->plate_number ?>"><?= $bike->plate_number ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php foreach($bikes as $bike): ?>
        <div class="photoSection">
    <div class="photoBox" data-image="unloaded">
        <div class="photoCaption">Side</div>
        <img class="photoImage" src="<?= site_url('Admin/Bikes/displayBikePhoto/') . $bike->pic_side ?>">
        <div class="deleteButton">Delete</div> 
        <label class="selectPhoto" for="pic_side">Select Photo</label>
        <input autocomplete="off" type="file" class="photoInput" id="pic_side" name="pic_side">
    </div>

    <div class="photoBox" data-image="unloaded">
        <div class="photoCaption">Front</div>
        <img class="photoImage" src="">
        <div class="deleteButton">Delete</div>
        <label class="selectPhoto" for="pic_front">Select Photo</label>
        <input autocomplete="off" type="file" class="photoInput" id="pic_front" name="pic_front">
    </div>

    <div class="photoBox" data-image="unloaded">
        <div class="photoCaption">Rear</div>
        <img class="photoImage" src="">
        <div class="deleteButton">Delete</div>
        <label class="selectPhoto" for="pic_rear">Select Photo</label>
        <input autocomplete="off" type="file" class="photoInput" id="pic_rear" name="pic_rear">
    </div>

    <div class="photoBox" data-image="unloaded">
        <div class="photoCaption">Trunk</div>
        <img class="photoImage" src="">
        <div class="deleteButton">Delete</div>
        <label class="selectPhoto" for="pic_trunk">Select Photo</label>
        <input autocomplete="off" type="file" class="photoInput" id="pic_trunk" name="pic_trunk">
    </div>
        
    </div>
    <?php endforeach; ?>

    <script>
        // Dynamically generate options for year select menu (so current year is always at top)
        const currentYear = new Date().getFullYear();
        const year = document.querySelector('#year');

        for(let i = 0; i < 20; i++) {
            let yearOption = document.createElement('option');
            yearOption.value = yearOption.innerHTML = currentYear - i;
            year.appendChild(yearOption);
        }
    </script>
</body>
</html>