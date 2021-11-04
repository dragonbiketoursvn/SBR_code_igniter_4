<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Test 1<?= $this->endSection() ?>

<?= $this->section("content") ?>

    <p>
        <img src="<?= site_url('Test/showImage/') ?>" alt="image can't display">
    </p>

<?= $this->endSection() ?>
