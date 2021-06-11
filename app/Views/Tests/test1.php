<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Test 1<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="modal">
  <div class="modal-background"></div>
  <div class="modal-card">

    <section class="modal-card-body" style="font-size: 2vw !important; text-align: center !important;">

    </section>
    <footer class="modal-card-foot">
      <button type="submit" form="payment_form" class="button is-success" style="width: 50% !important;">Dúng rồi. Nhập đi!</button>
      <button class="button is-danger close-toggle" style="width: 50% !important;">Tôi cần chỉnh lại</button>
    </footer>
  </div>
</div>


<button class="penis toggle">Press</button>


<?= $this->endSection() ?>
