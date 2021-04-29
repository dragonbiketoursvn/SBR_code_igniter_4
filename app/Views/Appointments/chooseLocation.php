<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
      button {border-radius: 10px; background-color: turquoise;}
      .sunday {border-radius: 10px; background-color: gray; color: gray;}
      .alreadyBooked {border-radius: 10px; background-color: green; color: yellow; border: 2px solid red}
      table {border: 0px;}
    </style>

    <title>WTF?</title>

</head>

<body>

  <?= form_open(site_url('/appointments/saveLocation/' . $token)); ?>

    <label for="building_name">Building Name</label>
    <input type="text" id="building_name" name="building_name" value="<?= esc($appointment->building_name) ?>">

    <label for="number">Number</label>
    <input type="text" id="number" name="number" value="<?= esc($appointment->number) ?>">

    <label for="street_name">Street</label>
    <input type="text" id="street_name" name="street_name" value="<?= esc($appointment->street_name) ?>">

    <label for="ward">Ward</label>
    <input type="text" id="ward" name="ward" value="<?= esc($appointment->ward) ?>">

    <label for="district">District</label>
    <input type="text" id="district" name="district" value="<?= esc($appointment->district) ?>">

    <button>Submit</button>
  </form>


</body>
</html>
