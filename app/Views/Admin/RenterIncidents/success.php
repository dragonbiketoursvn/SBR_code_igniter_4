<?= $this->extend("layouts/default") ?>


<?= $this->section('title') ?>Success<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="block">
  <section class="hero is-danger">
    <div class="hero-body has-text-centered" style="margin-bottom: 0px;">
      <p class="title">
       SUCCESS!!!
      </p>
    </div>
  </section>
</div>


<script>

const forward = function() {

  window.location.href = 'http://sbr_code_igniter_4.localhost/Admin/Home/index';

}

 window.onload = function() {

   setInterval(forward, 1000);

 }

</script>

<?= $this->endSection() ?>