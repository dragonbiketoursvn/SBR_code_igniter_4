<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Test 2<?= $this->endSection() ?>

<?= $this->section("content") ?>

<h1>Test 3</h1>

<p>The value submitted by the form in Test 2 is <?= $henrietta ?></p>

<?= form_open("/Test/testFour") ?>

<input type="text" name="value_three">Value three

<button>Submit</button>

</form>

<?= $this->endSection() ?>
