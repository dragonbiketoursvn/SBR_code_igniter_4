<?= $this->extend("layouts/defaultNoBack") ?>

<?= $this->section('title') ?>Location Selector<?= $this->endSection() ?>

<?= $this->section("content") ?>

  <div class="block">
    <section class="hero is-link">
      <div class="hero-body has-text-centered" style="margin-bottom: 0px;">
        <p class="title">
         Nếu Có Thêm Gì Cần Ghi Lại Thì Viết Ngay Dưới Đây
        </p>
      </div>
    </section>
  </div>

<?= form_open(site_url('Admin/Appointments/saveNotes')) ?>

  <div class="field is-horizontal">
    <div class="field-body">
      <div class="field">
          <input autocomplete="off" class="input is-success" type="textarea" id="notes" name="notes">
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
          <button class="button is-success is-large is-fullwidth">
              Nhập Và Xuất
          </button>
        </div>
      </div>
    </div>
  </div>

</form>

<?= $this->endSection() ?>
