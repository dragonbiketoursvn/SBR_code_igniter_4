<?= $this->extend("layouts/default") ?>

<?= $this->section('title') ?>Get Customer Info<?= $this->endSection() ?>

<?= $this->section("content") ?>

<?php if (session()->has('errors')) : ?>
    <p>
        <?= session()->get('errors') ?>
    </p>
<?php endif; ?>

<?= form_open('Admin/Customers/broadcastMessage') ?>

    <div class="control">
        <label class="radio">
            <input type="radio" name="selection" value="monthly">
            Monthly
        </label>
        <label class="radio">
            <input type="radio" name="selection" value="short-term">
            Short-Term
        </label>
    </div>

    <div class="field is-horizontal" style="bottom: 200px !important;">
        <div class="field-label is-normal">
          <label class="label" for="subject">Subject</label>
        </div>
        <div class="field-body">
          <div class="field">
            <p class="control is-expanded">
              <input autocomplete="off" class="input is-success" id="subject" name="subject">
            </p>
          </div>
        </div>
    </div>

    <label>Message
        <textarea class="textarea" rows="10" name="message" warp="soft"></textarea>
    </label>

    <div class="field is-horizontal">
        <div class="field-label">
            <!-- Left empty for spacing -->
        </div>
        <div class="field-body">
            <div class="field">
                <div class="control">
                    <button class="button is-success is-large is-fullwidth">
                        Send
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<a class="button is-warning is-large is-fullwidth" href="<?= site_url('/Admin/Home') ?>">Main Page</a>

<script>
    const form = document.querySelector('form');
    const blockSubmission = (evt) => {
        evt.preventDefault();
    };
    form.addEventListener('submit', blockSubmission);
    const radios = document.querySelectorAll('input[type="radio"]');
    radios.forEach(radio => {
        radio.addEventListener('input', () => {
            form.removeEventListener('submit', blockSubmission);
        });
    })
</script>man
<?= $this->endSection() ?>

