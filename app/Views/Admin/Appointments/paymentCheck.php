<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Location Selector<?= $this->endSection() ?>

<?= $this->section("content") ?>

  <div class="block">
    <section class="hero is-link">
      <div class="hero-body has-text-centered" style="margin-bottom: 0px;">
        <p class="title">
         Khách Trả Tiền Không?
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
          <?= form_open("Admin/Payments/makeNew") ?>
            <button class="button is-success is-large is-fullwidth">
              Có
            </button>
          </form>
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
          <?= form_open("Admin/Appointments/bikeStatusCheck") ?>
            <button class="button is-danger is-large is-fullwidth">
              Không
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

<?= $this->endSection() ?>
