<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Test 2<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?= form_open_multipart("/Test/testTwo") ?>

<label for="photo">asl;kfj;alskjdf;asdf</label>
<input type="file" name="photo" id="photo">

<button>Submit</button>

</form>

<?= $this->endSection() ?>
