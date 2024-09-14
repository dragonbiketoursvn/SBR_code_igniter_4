<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Customer Info<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="block">
  <table class="table block is-fullwidth">
    <thead>
      <tr>
        <th>
          Current Customers With No Associated Bike
        </th>
      </tr>
      <tr>
        <th>Name</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($customersNoBike as $customer) : ?>
        <tr>
          <td><?= $customer->customer_name ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="block">
  <table class="table block is-fullwidth">
    <thead>
      <tr>
        <th>
          Bikes Not In Garage Or With Customer
        </th>
      </tr>
      <tr>
        <th>Plate Number</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($bikesNotGargeOrCustomer as $bike) : ?>
        <tr>
          <td><?= $bike['plate_number'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="block">
  <table class="table block is-fullwidth">
    <thead>
      <tr>
        <th>
          Bikes With Multiple Customer Statuses
        </th>
      </tr>
      <tr>
        <th>Plate Number</th>
        <th>Customer ID</th>
        <th>Customer Name</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($bikesMultipleStatus as $bike) : ?>
        <tr>
          <td><?= $bike['plate_number'] ?></td>
          <td><?= $bike['customer_id'] ?></td>
          <td><?= $bike['new_status'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="block">
  <table class="table block is-fullwidth">
    <thead>
      <tr>
        <th>
          Customers Associated Bike Actually in Garage
        </th>
      </tr>
      <tr>
        <th>Customer Name</th>
        <th>Customer ID</th>
        <th>Plate Number</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($customersBikeInGarage as $customer) : ?>
        <tr>
          <td><?= $customer['new_status'] ?></td>
          <td><?= $customer['customer_id'] ?></td>
          <td><?= $customer['plate_number'] ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>


<?= $this->endSection() ?>