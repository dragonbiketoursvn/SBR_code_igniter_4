<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bikes in Garage</title>
  <style>
    table {
      border: 2px solid black;
      border-collapse: collapse;
      margin-bottom: 4%;
      width: 90%;
    }

    tr:nth-child(2n + 1) {
      background-color: #eee;
    }

    td,
    th {
      border: 1px solid black;
      padding: 0.2em;
    }

    body {
      position: relative;
    }

    .hidden {
      display: none;
    }

    .filterOptions {
      position: absolute;
      top: 20%;
      left: 10%;
      margin: auto;
      height: 200px;
      width: 400px;
      background: yellow;
    }

    input[name="min"] {
      top: 5%;
      position: absolute;
    }

    input[name="max"] {
      top: 20%;
      position: absolute;
    }

    .apply {
      left: 2em;
      bottom: 10%;
      position: absolute;
    }

    .cancel {
      left: 10em;
      bottom: 10%;
      position: absolute;
    }

    .removeFilters {
      position: fixed;
      width: 50%;
      height: 5%;
      margin: auto;
      bottom: 2%;
    }

    .remove {
      width: 90%;
      height: 3em;
      background-color: red;
      color: #eeeeee;
    }

    .backToMain {
      width: 90%;
      height: 5em;
      background-color: green;
      color: #eeeeee;
      font-size: 2em;
    }
  </style>
</head>

<body>
  <table id="displayTable">
    <tr id="filterRow">
      <th data-column="column1" class="date">Date</th>
      <th data-column="column2">Amount</th>
      <th data-column="column3">Category</th>
      <th data-column="column4">Dragon Bikes</th>
      <th data-column="column5">Saigon Bike Rentals</th>
      <th data-column="column6">Personal</th>
      <th data-column="column7">Quantity</th>
    </tr>

    <?php foreach ($expenses as $expense) : ?>
      <tr>
        <td class="column1"><?= $expense->date; ?></td>
        <td class="column2"><?= $expense->amount; ?></td>
        <td class="column3"><?= $expense->category; ?></td>
        <td class="column4"><?= $expense->dragon_bikes; ?></td>
        <td class="column5"><?= $expense->personal; ?></td>
        <td class="column6"><?= $expense->quantity; ?></td>
      </tr>
    <?php endforeach; ?>


  </table>

  <a href="<?= site_url('Admin/Home') ?>"><button class="backToMain">Main Menu</button></a>

</body>

</html>