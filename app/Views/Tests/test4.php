<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Test 2<?= $this->endSection() ?>

<?= $this->section("content") ?>

<h1>Test 4</h1>

<p>The value submitted by the form in Test 3 is <?= $dildo ?></p>

<form method="post" action="/Test/testFive">

<input type="text" name="value_four">Value four

<button>Submit</button>

</form>

<?= $this->endSection() ?>
