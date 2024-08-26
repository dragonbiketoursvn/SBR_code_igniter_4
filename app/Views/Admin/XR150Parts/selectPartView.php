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
        <a href="<?= site_url("Admin/XR150Parts/viewBestPrices") ?>">
          <button class="button is-success is-large is-fullwidth">
            View Best Prices
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
        <a href="<?= site_url("Admin/XR150Parts/viewCurrentPricesAll") ?>">
          <button class="button is-warning is-large is-fullwidth">
            View Current Prices All Suppliers
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
        <a href="<?= site_url('Admin/XR150Parts/viewAllSuppliers') ?>">
          <button class="button is-link is-large is-fullwidth">
            View All Suppliers
          </button>
        </a>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>