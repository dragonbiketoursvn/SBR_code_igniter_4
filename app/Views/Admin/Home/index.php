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
        <a href="<?= site_url("Admin/Customers/newContract") ?>">
          <button class="button is-link is-large is-fullwidth">
            Làm Hợp Đồng Mới
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
        <a href="<?= site_url("Admin/Expenses/chooseDivision") ?>">
          <button class="button is-warning is-large is-fullwidth">
            Chi Phí Khác
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
        <a href="<?= site_url("Admin/Repairs/getHistory") ?>">
          <button class="button is-danger is-large is-fullwidth">
            Xem Lịch Sự Sửa Xe
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
        <a href="<?= site_url("Admin/BikeValuations/getRecord") ?>">
          <button class="button is-link is-large is-fullwidth">
            Nộp Giá Xe
          </button>
        </a>
      </div>
    </div>
  </div>
</div>

<?php if (session()->get('user_level') == 'super') : ?>

  <div class="field is-horizontal">
    <div class="field-label">
      <!-- Left empty for spacing -->
    </div>
    <div class="field-body">
      <div class="field">
        <div class="control">
          <a href="<?= site_url("Admin/Customers/selectCustomerView") ?>">
            <button class="button is-success is-large is-fullwidth">
              Customer View
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
          <a href="<?= site_url("Admin/RenterIncidents/incidents") ?>">
            <button class="button is-danger is-large is-fullwidth">
              Customer Incidents
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
          <a href="<?= site_url("Admin/MoneyToStaff/getInfo") ?>">
            <button class="button is-link is-large is-fullwidth">
              Money to Khanh
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
          <a href="<?= site_url("Admin/Bikes/selectView") ?>">
            <button class="button is-success is-large is-fullwidth">
              Bike Profiles
            </button>
          </a>
        </div>
      </div>
    </div>
  </div>

<?php endif; ?>

<?= $this->endSection() ?>