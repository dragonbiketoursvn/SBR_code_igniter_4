<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Payment Form<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="block">
  <section class="hero is-danger">
    <div class="hero-body has-text-centered" style="margin-bottom: 0px;">
      <p class="title">
        Add Purchase
      </p>
    </div>
  </section>
</div>

<?= form_open('Admin/XR150Parts/addPurchase', 'id="new_purchase_form" class="random_class"') ?>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="part_name">Part Name</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input autofocus autocomplete="off" list="part_name_list" class="input is-success" id="part_name" name="part_name">
      <datalist id="part_name_list">
        <?php foreach ($parts as $part) : ?>
          <option value="<?= $part->name ?>">
          <?php endforeach; ?>
      </datalist>
    </div>
  </div>
</div>


<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="supplier_name">Supplier</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <select autocomplete="off" class="input is-success" id="supplier_name" name="supplier_name">
          <?php foreach ($suppliers as $supplier) : ?>
            <option value="<?= $supplier->name ?>"><?= $supplier->name ?></option>
          <?php endforeach; ?>
        </select>
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="price_vnd">Price VND (x1000)</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input autocomplete="off" class="input is-success" type="number" id="price_vnd" name="price_vnd">
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="price_usd">Price USD</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input autocomplete="off" class="input is-success" type="text" id="price_usd" name="price_usd">
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="quantity">Quantity</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input autocomplete="off" class="input is-success" type="number" id="quantity" name="quantity">
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="purchase_date">Purchase Date</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input required autocomplete="off" class="input is-success" type="date" id="purchase_date" name="purchase_date" value="<?= date('Y-m-d') ?>">
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