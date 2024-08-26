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
        <a href="<?= site_url("Admin/XR150Parts/newPart") ?>">
          <button class="button is-success is-large is-fullwidth">
            Add Part Info
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
        <a href="<?= site_url("Admin/XR150Parts/newPurchase") ?>">
          <button class="button is-warning is-large is-fullwidth">
            Add Purchase Info
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
        <a href="<?= site_url("Admin/XR150Parts/newInventory") ?>">
          <button class="button is-danger is-large is-fullwidth">
            Add Inventory Info
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
        <a href="<?= site_url('Admin/XR150Parts/newSupplier') ?>">
          <button class="button is-link is-large is-fullwidth">
            Add Supplier Info
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
        <a href="<?= site_url("Admin/XR150Parts/selectPartView") ?>">
          <button class="button is-success is-large is-fullwidth">
            View Part Info
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
            View Supplier Info
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
        <a href="<?= site_url("Admin/XR150Parts/viewInventory") ?>">
          <button class="button is-danger is-large is-fullwidth">
            View Inventory
          </button>
        </a>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>