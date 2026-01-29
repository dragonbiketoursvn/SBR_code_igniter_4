<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Customer Info<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php if (session()->has('errors')) : ?>
  <p>
    <?= session()->get('errors') ?>
  </p>
<?php endif; ?>

<div class="field is-horizontal">
  <div class="field-label">
    <!-- Left empty for spacing -->
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <a href="<?= site_url('Admin/HouseholdItems/addRecord') ?>">
          <button class="button is-success is-large is-fullwidth toggle">
            Add New
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
        <a href="<?= site_url('Admin/HouseholdItems/viewAll') ?>">
          <button class="button is-warning is-large is-fullwidth toggle">
            View All (Photos)
          </button>
        </a>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>