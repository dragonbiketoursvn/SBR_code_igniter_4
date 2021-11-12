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
                <a href="<?= site_url('Admin/Customers/viewCurrentCustomers') ?>">
                    <button class="button is-success is-large is-fullwidth toggle">
                        View Current Customers
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
                <a href="<?= site_url('Admin/Customers/viewAllCustomers') ?>">
                    <button class="button is-available is-large is-fullwidth toggle">
                        View All Customers
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>