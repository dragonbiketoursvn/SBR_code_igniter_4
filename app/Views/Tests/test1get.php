<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Test 1<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php if (isset(($test_value))): ?>

  <h1>Your value is <?= $test_value ?>!</h1>

<?php else: ?>

  <h1>Submit Something!</h1>

  <?= form_open() ?>

  <input type="text" name="test_value" placeholder="Input Test Value">

  <button>Submit</button>

  </form>

<?php endif; ?>

<?= $this->endSection() ?>
