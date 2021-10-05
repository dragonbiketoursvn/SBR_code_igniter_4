<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Location Selector<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="field is-horizontal">
  <div class="field-label">
    <!-- Left empty for spacing -->
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <a href="<?= site_url("Admin/RenterIncidents/newIncident") ?>">
          <button class="button is-success is-large is-fullwidth">
              Record New Incident
          </button>
        </a>
      </div>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label">
    <!-- Left empty for spacing -->
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <a href="<?= site_url("Admin/RenterIncidents/viewUnresolvedIncidents") ?>">
          <button class="button is-warning is-large is-fullwidth">
            View Unresolved Incidents
          </button>
        </a>
      </div>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label">
    <!-- Left empty for spacing -->
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <a href="<?= site_url("Admin/RenterIncidents/viewByRenter") ?>">
          <button class="button is-danger is-large is-fullwidth">
              View Incidents by Customer
          </button>
        </a>
      </div>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label">
    <!-- Left empty for spacing -->
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <a href="<?= site_url('Admin/RenterIncidents/viewAll') ?>">
          <button class="button is-link is-large is-fullwidth">
              View All Incidents
          </button>
        </a>
      </div>
    </div>
  </div>
</div>


<?= $this->endSection() ?>