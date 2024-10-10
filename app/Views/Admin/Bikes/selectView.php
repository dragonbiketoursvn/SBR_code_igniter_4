<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Customer Info<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php if (session()->has('errors')) : ?>
    <p>
        <?= session()->get('errors') ?>
    </p>
<?php endif; ?>

<div class="field is-horizontal">
    <div class="field-label">
        <!-- Left empty for spacing -->
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control">
                <a href="<?= site_url('Admin/Bikes/addRecord') ?>">
                    <button class="button is-success is-large is-fullwidth toggle">
                        Create New
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="field is-horizontal">
    <div class="field-label">
        <!-- Left empty for spacing -->
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control">
                <a href="<?= site_url('Admin/Bikes/viewIndividual') ?>">
                    <button class="button is-available is-large is-fullwidth toggle">
                        View Individual
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="field is-horizontal">
    <div class="field-label">
        <!-- Left empty for spacing -->
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control">
                <a href="<?= site_url('Admin/Bikes/viewAll') ?>">
                    <button class="button is-warning is-large is-fullwidth toggle">
                        View All (Photos)
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="field is-horizontal">
    <div class="field-label">
        <!-- Left empty for spacing -->
    </div>
    <div class="field-body">
        <div class="field">
            <div class="control">
                <a href="<?= site_url('Admin/Bikes/viewData') ?>">
                    <button class="button is-danger is-large is-fullwidth toggle">
                        View All (Data Table)
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>