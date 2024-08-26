<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Current Customers</title>
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
      <th data-column="column1">Code</th>
      <th data-column="column2">Name</th>
      <th data-column="column3">Price (USD)</th>
      <th data-column="column4" class="date">Price (VND)</th>
      <th data-column="column5" class="date">Supplier</th>
      <th data-column="column6" class="date">Last Order Date</th>
    </tr>

    <?php foreach ($bestPrices as $bestPrice) : ?>
      <tr>
        <td class="column1"><?= $bestPrice->code ?></td>
        <td class="column2"><?= $bestPrice->part_name ?></td>
        <td class="column3"><?= $bestPrice->price_usd ?></td>
        <td class="column4"><?= $bestPrice->price_vnd ?></td>
        <td class="column5"><?= $bestPrice->supplier_name ?></td>
        <td class="column6"><?= $bestPrice->date ?></td>
      </tr>
    <?php endforeach; ?>


  </table>

  <a href="<?= site_url('Admin/Home') ?>"><button class="backToMain">Main Menu</button></a>

</body>

</html>