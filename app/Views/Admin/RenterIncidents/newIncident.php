<?= $this->extend("layouts/default") ?>


<?= $this->section('title') ?>Payment Form<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="block">
  <section class="hero is-danger">
    <div class="hero-body has-text-centered" style="margin-bottom: 0px;">
      <p class="title">
       Incident Report
      </p>
    </div>
  </section>
</div>

<?php if(session()->has('errors')): ?>
  <div class="block">
    <ul>
      <?php foreach(session('errors') as $error): ?>
        <li style="color: tomato;"><b><?= $error ?></b></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?= form_open('Admin/RenterIncidents/saveIncident', 'id="incident_form" class="random_class"') ?>



<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="type">Incident Type</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input list="type_list" class="input is-success" type="text" id="type" name="type">
      <datalist id="type_list">
          <option value="BREAKDOWN">
          <option value="ACCIDENT">
          <option value="THEFT BY 3RD PARTY">
          <option value="THEFT BY RENTER">
      </datalist>
    </div>
  </div>
</div>


<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="customer_name">Customer Name</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input list="customer_name_list" class="input is-success" id="customer_name" name="customer_name">
        <datalist id="customer_name_list">
          <?php foreach($customers as $customer): ?>
            <option value="<?= $customer->customer_name ?>">
          <?php endforeach; ?>
        </datalist>
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="cost_incurred">Cost Incurred</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" type="text" id="cost_incurred" name="cost_incurred">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="resolution">Resolution</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input class="input is-success" type="textarea" id="resolution" name="resolution">
      </p>
    </div>
  </div>
</div>

<input type="hidden" id="date" name="date" value="<?= date('Y-m-d') ?>">

</form>

<div class="field is-horizontal">
  <div class="field-label">
    <!-- Left empty for spacing -->
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <button class="button is-available is-large is-fullwidth toggle">
          Submit
        </button>
      </div>
    </div>
  </div>
</div>




<div class="modal">
  <div class="modal-background"></div>
  <div class="modal-card">

    <section class="modal-card-body" style="font-size: 15px !important; text-align: center !important; padding: 2px !important;">

    </section>
    <footer class="modal-card-foot">
      <button type="submit" form="incident_form" class="button is-success" style="width: 50% !important;">Dúng rồi. Nhập đi!</button>
      <button class="button is-danger close-toggle" style="width: 50% !important;">Tôi cần chỉnh lại</button>
    </footer>
  </div>
</div>

<script>

//Form validation
const form = document.querySelector('.random_class');


  //Modal stuff
  const modal = document.querySelector('.modal');
  const buttonOpenModal = document.querySelector('.toggle');
  const buttonCloseModal = document.querySelector('.close-toggle');

  const stringSegment1 = "Khách trả <b>";
  const stringSegment2 = "</b> đồng <br>cho <b>";
  const stringSegment3 = "</b> tháng. <br> Các con số này có đúng ko?";

  const toggle = function() {

    let amount = document.querySelector('input[name="amount"]');
    let months_paid = document.querySelector('input[name="months_paid"]');
    modal.classList.add('is-active');

    document.querySelector('.modal-card-body').innerHTML = `${stringSegment1}${amount.value}${stringSegment2}${months_paid.value}${stringSegment3}`;

   };

   const closeToggle = function() {

    modal.classList.remove('is-active');

   };

  buttonOpenModal.addEventListener('click', toggle);
  buttonCloseModal.addEventListener('click', closeToggle);

</script>

<?= $this->endSection() ?>
