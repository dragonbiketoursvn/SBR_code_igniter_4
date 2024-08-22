<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Payment Form<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="block">
  <section class="hero is-danger">
    <div class="hero-body has-text-centered" style="margin-bottom: 0px;">
      <p class="title">
        Add Supplier
      </p>
    </div>
  </section>
</div>

<?= form_open('Admin/XR150Parts/addSupplier', 'id="new_supplier_form" class="random_class"') ?>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="name">Supplier Name</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input autofocus autocomplete="off" class="input is-success" type="text" id="name" name="name">
    </div>
  </div>
</div>


<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="location">Supplier Location</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autocomplete="off" class="input is-success" id="location" name="location">
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