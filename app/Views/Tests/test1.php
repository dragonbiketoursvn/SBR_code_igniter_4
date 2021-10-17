<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Test 1<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php 

if(session()->has('warning')) {

  echo session()->get('warning');

} 

?>

<?= form_open_multipart("Test/testTwo") ?>

  <input type="file" name="profile_images">Choose 1st image
  <input type="file" name="second_images">Choose 2nd image

  <button>Submit</button>
</form>

<?= $this->endSection() ?>
