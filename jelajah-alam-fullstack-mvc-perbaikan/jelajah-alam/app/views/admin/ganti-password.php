<section class="auth-wrap">
    <form class="panel" method="post" action="<?= url('admin/gantiPassword') ?>" novalidate>
        <h1>Ganti password</h1>
        <?= csrf_field() ?>

        <label for="current">Password saat ini</label>
        <input id="current" type="password" name="current" required autocomplete="current-password">
        <?= field_error($errors, 'current') ?>

        <label for="new">Password baru (minimal 8 karakter)</label>
        <input id="new" type="password" name="new" required minlength="8" autocomplete="new-password">
        <?= field_error($errors, 'new') ?>

        <label for="confirm">Ulangi password baru</label>
        <input id="confirm" type="password" name="confirm" required autocomplete="new-password">
        <?= field_error($errors, 'confirm') ?>

        <div class="form-actions">
            <button class="btn" type="submit">Simpan password</button>
            <a class="btn btn-outline" href="<?= url('admin') ?>">Batal</a>
        </div>
    </form>
</section>
