<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Currently in Garage<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php if (session()->has('errors')) : ?>
  <ul>
    <?php foreach (session('errors') as $error) : ?>
      <li>
        <?= $error ?>
      <li>
      <?php endforeach; ?>
      <ul>
      <?php endif; ?>

      <div class="field is-horizontal">
        <div class="field-label">
          <!-- Left empty for spacing -->
        </div>
        <div class="field-body">
          <div class="field">
            <div class="control">
              <a href="<?= site_url('Admin/Home') ?>">
                <button class="button is-warning is-large is-fullwidth">
                  Back to Main Menu
                </button>
              </a>
            </div>
          </div>
        </div>
      </div>

      <script>
        const url = new URL(location.href);
        const origin = url.origin;
        let response;

        (async function getReservations() {
          response = await fetch(`${url.origin}/Admin/Reservations/getActiveReservations`);
          const reservations = await response.json();

          reservations.forEach(reservation => {
            reservation.start_date = new Date(reservation.start_date);
            reservation.end_date = new Date(reservation.end_date);
          });

          reservations.sort((a, b) => a.start_date - b.start_date || b.end_date - a.end_date);

          reservations.forEach(reservation => {
            console.log(reservation.start_date);
            console.log(reservation.end_date);
          });
        })();
      </script>

      <?= $this->endSection() ?>