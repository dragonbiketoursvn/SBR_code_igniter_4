<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Test 2<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php dd($_SESSION);
      ?>

<h1>Test 2</h1>

<p>The value submitted by the form in Test 1 is <?= $thomas ?> </p>

<?= form_open("/Test/testThree") ?>

<input type="text" name="value_two">Value two

<button>Submit</button>

</form>

<?= $this->endSection() ?>
