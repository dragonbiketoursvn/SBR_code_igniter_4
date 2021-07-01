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
        <a href="<?= site_url("Admin/Appointments/showAll") ?>">
          <button class="button is-success is-large is-fullwidth">
              Xem Lịch Cuộc Hẹn
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
        <a href="<?= site_url("Admin/Appointments/addNew") ?>">
          <button class="button is-warning is-large is-fullwidth">
              Bắt Đầu Lúc Gặp Khách &nbsp; <span style="text-decoration: underline;">KHÔNG CÓ HẸN</span>
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
        <a href="<?= site_url("Admin/MoveBike/getInfo") ?>">
          <button class="button is-danger is-large is-fullwidth">
              Xe Chuyển Qua Nơi Mới
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
        <button class="button is-link is-large is-fullwidth">
            Làm Hợp Đồng Mới
        </button>
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
        <a href="<?= site_url("Admin/Repairs/getInfo") ?>">
          <button class="button is-success is-large is-fullwidth">
              Phiếu Sửa Xe
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
        <button class="button is-warning is-large is-fullwidth">
            Chi Phí Khác
        </button>
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
        <button class="button is-danger is-large is-fullwidth">
            Xem Lịch Sự Sửa Xe
        </button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
