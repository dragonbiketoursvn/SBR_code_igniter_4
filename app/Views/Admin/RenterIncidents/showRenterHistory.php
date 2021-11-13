<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Show Renter History<?= $this->endSection() ?>

<?= $this->section("content") ?>


<table class="table block is-fullwidth">
  <thead>
    <tr>
      <th>Customer Name</th>
      <th>Plate Number</th>
      <th>Date</th>
      <th>Incident Type</th>
      <th>Cost Incurred</th>
      <th>Resolution</th>
      <th>
      <th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($incidents as $incident) : ?>
      <tr>
        <td><?= $incident->customer_name ?></td>
        <td><?= $incident->plate_number ?></td>
        <td><?= $incident->date ?></td>
        <td><?= $incident->type ?></td>
        <td><?= $incident->cost_incurred ?? '' ?></td>
        <td><?= $incident->resolution ?? '' ?></td>
        <td><a href="<?= site_url('Admin/RenterIncidents/update/' . $incident->id) ?>"><button class="button is-fullwidth is-link">Edit</button></a></td </tr>
      <?php endforeach; ?>
  </tbody>
</table>

<div class="field is-horizontal">
  <div class="field-label">
    <!-- Left empty for spacing -->
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <a href="<?= site_url("Admin/Home/index") ?>">
          <button class="button is-success is-large is-fullwidth">
            Return to Main Admin Page
          </button>
        </a>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>