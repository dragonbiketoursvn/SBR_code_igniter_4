<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Test 2<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?= form_open_multipart("/Test/testTwo") ?>

<label for="passport">Dick pics go here</label>
<input type="file" name="passport" id="passport">

<label for="nextPhoto">Other pics go here</label>
<input type="file" name="nextPhoto" id="photo">

<label for="text">Random Text</label>
<input type="text" name="text">

<label for="text">More Random Text</label>
<input type="moreText" name="moreText">

<button>Submit</button>

</form>

<?= $this->endSection() ?>
