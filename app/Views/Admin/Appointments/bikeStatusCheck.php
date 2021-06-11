<?= $this->extend("layouts/defaultNoBack") ?>

<?= $this->section('title') ?>Bike Status Change<?= $this->endSection() ?>

<?= $this->section("content") ?>

  <div class="block">
    <section class="hero is-link">
      <div class="hero-body has-text-centered" style="margin-bottom: 0px;">
        <p class="title">
         Khách Đổi/Nhận/Trả Lại Xe Không?
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
          <a href="<?= site_url("Admin/Appointments/getStatusChange") ?>">
            <button class="button is-success is-large is-fullwidth">
              Có
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
          <?= form_open("Admin/Appointments/finalCheck") ?>
            <button class="button is-danger is-large is-fullwidth">
              Không
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

<?= $this->endSection() ?>
