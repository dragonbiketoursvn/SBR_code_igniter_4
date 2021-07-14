<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Customer Info<?= $this->endSection() ?>

<?= $this->section("content") ?>


  <table class="table block is-fullwidth">
    <thead>
      <tr>
        <th>Customer Name</th>
        <th>Incident Type</th>
        <th>Cost Incurred</th>
        <th>Resolution</th>
        <th><th>
      </tr>
    </thead>

    <tbody>
        <?php foreach($incidents as $incident): ?>
          <tr>
            <td><?= $incident->customer_name ?></td>
            <td><?= $incident->type ?></td>
            <td><?= $incident->cost_incurred ?? '' ?></td>
            <td></td>
            <td><a href="<?= site_url('Admin/RenterIncidents/update/' . $incident->id) ?>"><button class="button is-fullwidth is-link">Edit</button></a></td
          </tr>
        <?php endforeach; ?>
    </tbody>
  </table>


<?= $this->endSection() ?>
