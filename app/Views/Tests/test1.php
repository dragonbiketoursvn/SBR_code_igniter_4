<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Test 1<?= $this->endSection() ?>

<?= $this->section("content") ?>

<h1>Test 1</h1>




<?= form_open("/Test/testTwo") ?>

<input type="text" name="value_one">Value one

<button>Submit</button>

</form>

<?= $this->endSection() ?>
