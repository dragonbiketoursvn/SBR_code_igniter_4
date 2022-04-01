<?= $this->extend('layouts/default') ?>

<?= $this->section('title') ?>Login<?= $this->endSection() ?>

<?= $this->section('content') ?>



<div class="container">
  <h1 class="title">Log In</h1>
  <?= form_open(site_url("caribe/login/create")) ?>

  <div class="field">
    <label class="label" for="email">Email</label>
    <input class="input" type="text" name="email" id="email" value="<?= old('email') ?>">
  </div>

  <div class="field">
    <label class="label" for="password">Password</label>
    <input class="input" type="password" name="password">
  </div>

  <div class="field">
    <label class="checkbox" for="remember_me">
      <input type="checkbox" id="remember_me" name="remember_me" <?php if (old('remember_me')) : ?>checked<?php endif; ?>> Remember Me
    </label>
  </div>

  <div class="field is-grouped">
    <div class="control">
      <button class="button is-primary">Log In</button>
    </div>

  </div>

  </form>

</div>

<?= $this->endSection() ?>