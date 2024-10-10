<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Compensation Ticket<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="block">
  <section class="hero is-danger">
    <div class="hero-body has-text-centered" style="margin-bottom: 0px;">
      <p class="title">
        Create Compensation Ticket
      </p>
    </div>
  </section>
</div>

<?php if (session()->has('errors')) : ?>
  <div class="block">
    <ul>
      <?php foreach (session('errors') as $error) : ?>
        <li style="color: tomato;"><b><?= $error ?></b></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?= form_open('Admin/compensationTickets/create') ?>

<input type="hidden" id="customer_id" name="customer_id" value="<?= $customerId ?>">

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="date">Date</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autocomplete="off" type="date" class="input is-success" id="date" name="date" value="<?= date('Y-m-d') ?>">
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="stolen_destroyed_damaged">Stolen, Destroyed, or Damaged?</label>
  </div>
  <div class="field-body">
    <div class="select">
      <select name="stolen_destroyed_damaged">
        <option value="STOLEN">STOLEN</option>
        <option value="DESTROYED">DESTROYED</option>
        <option value="DAMAGED">DAMAGED</option>
      </select>
    </div>
  </div>
</div>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="plate_number">Plate Number</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autocomplete="off" list="plate_number_list" class="input is-success" id="plate_number" name="plate_number">
        <datalist id="plate_number_list">
          <?php foreach ($bikes as $bike) : ?>
            <option value="<?= $bike->plate_number ?>">
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
        <input autocomplete="off" class="input is-success" type="number" id="cost_incurred" name="cost_incurred">
      </p>
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
        <button class="button is-available is-large is-fullwidth toggle">
          Submit
        </button>
      </div>
    </div>
  </div>
</div>

</form>

<?= $this->endSection() ?>