<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Test 2<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php foreach($pathArray as $path): ?>

    <p>
        <h1><?= $path ?></h1>
        <a href="<?= $path ?>" download><img src="<?= $path ?>" alt="frog pussy"></a>
    </p>

<?php endforeach; ?>

<?= $this->endSection() ?>
