<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Payment Form<?= $this->endSection() ?>

<?= $this->section("content") ?>

<div class="block">
  <section class="hero is-danger">
    <div class="hero-body has-text-centered" style="margin-bottom: 0px;">
      <p class="title">
        Add Part
      </p>
    </div>
  </section>
</div>

<?= form_open_multipart('Admin/XR150Parts/addPart', 'id="new_part_form" class="random_class"') ?>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label" for="code">Part Code</label>
  </div>
  <div class="field-body">
    <div class="field">
      <input autofocus autocomplete="off" list="code_list" class="input is-success" type="text" id="code" name="code">
      <datalist id="code_list">
        <?php foreach ($parts as $part) : ?>
          <option value="<?= $part->code ?>">
          <?php endforeach; ?>
      </datalist>
    </div>
  </div>
</div>


<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="name">Part Name</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autocomplete="off" list="part_name_list" class="input is-success" id="name" name="name">
        <datalist id="part_name_list">
          <?php foreach ($parts as $part) : ?>
            <option value="<?= $part->name ?>">
            <?php endforeach; ?>
        </datalist>
      </p>
    </div>
  </div>
</div>

<div class="field is-horizontal" style="bottom: 200px !important;">
  <div class="field-label is-normal">
    <label class="label" for="part_image">Part Image</label>
  </div>
  <div class="field-body">
    <div class="field">
      <p class="control is-expanded">
        <input autocomplete="off" type="file" class="input is-success" id="part_image" name="part_image">
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