<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Location Selector<?= $this->endSection() ?>

<?= $this->section("content") ?>
<div class="block">
  <section class="hero is-link">
    <div class="hero-body has-text-centered" style="margin-bottom: 0px;">
      <p class="title">
       Chọn Xe Tháng hay Xe Du Lịch
      </p>
    </div>
  </section>
</div>

<div class="field is-horizontal">
  <div class="field-label">
    <!-- Left empty for spacing -->
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <a href="<?= site_url("Admin/Expenses/getInfo/" . "SBR") ?>">
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
        <a href="<?= site_url("Admin/Expenses/getInfo/" . "Dragon") ?>">
          <button class="button is-danger is-large is-fullwidth">
              Xe Du Lịch
          </button>
        </a>
      </div>
    </div>
  </div>
</div>


<?= $this->endSection() ?>
