<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Contract Selector<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="customer">Chọn Loại Hợp Đồng</label>
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <a href="<?= site_url("Admin/Customers/newContract") ?>">
          <button class="button is-success is-large is-fullwidth">
            Xe Tháng
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
        <a href="<?= site_url("Admin/Customers/newContractShort") ?>">
          <button class="button is-link is-large is-fullwidth">
            Xe Ngắn Hạn
          </button>
        </a>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>