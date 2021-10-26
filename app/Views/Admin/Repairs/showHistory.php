<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Repair History<?= $this->endSection() ?>

<?= $this->section("content") ?>

<table class="table">
  <thead>
    <tr>
      <th>Date</th>
      <th>Odometer</th>
      <th>Total Cost</th>
      <th>Labor</th>
      <th>Nhớt</th>
      <th>Item 1</th>
      <th>Item 2</th>
      <th>Item 3</th>
      <th>Item 4</th>
      <th>Item 5</th>
      <th>Item 6</th>
      <th>Item 7</th>
      <th>Item 8</th>
      <th>Item 9</th>
      <th>Item 10</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach($repairs as $repair): ?>
      <tr>
        <td><?= $repair->repair_date ?></td>
        <td><?= $repair->odometer ?></td>
        <td><?= $repair->total_cost ?></td>
        <td><?= $repair->labor_cost ?></td>
        <td><?= $repair->nhot ?></td>
        <td><?= $repair->item_1 ?></td>
        <td><?= $repair->item_2 ?></td>
        <td><?= $repair->item_3 ?></td>
        <td><?= $repair->item_4 ?></td>
        <td><?= $repair->item_5 ?></td>
        <td><?= $repair->item_6 ?></td>
        <td><?= $repair->item_7 ?></td>
        <td><?= $repair->item_8 ?></td>
        <td><?= $repair->item_9 ?></td>
        <td><?= $repair->item_10 ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>



<?= $this->endSection() ?>