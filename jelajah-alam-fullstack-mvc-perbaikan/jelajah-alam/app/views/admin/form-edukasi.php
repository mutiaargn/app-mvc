<?php
$val = fn(string $k) => e($old[$k] ?? ($item[$k] ?? ''));
$action = $item ? url('admin/editEdukasi/' . (int) $item['id']) : url('admin/tambahEdukasi');
?>
<section class="auth-wrap">
    <form class="panel" method="post" action="<?= $action ?>" novalidate>
        <h1><?= $item ? 'Edit artikel edukasi' : 'Tambah artikel edukasi' ?></h1>
        <?= csrf_field() ?>

        <label for="judul">Judul</label>
        <input id="judul" name="judul" required maxlength="180" value="<?= $val('judul') ?>">
        <?= field_error($errors, 'judul') ?>

        <label for="ringkasan">Ringkasan</label>
        <textarea id="ringkasan" name="ringkasan" rows="3" required maxlength="500"><?= $val('ringkasan') ?></textarea>
        <?= field_error($errors, 'ringkasan') ?>

        <label for="isi">Isi artikel</label>
        <textarea id="isi" name="isi" rows="9" required><?= $val('isi') ?></textarea>
        <?= field_error($errors, 'isi') ?>

        <div class="form-actions">
            <button class="btn" type="submit"><?= $item ? 'Simpan perubahan' : 'Publikasikan' ?></button>
            <a class="btn btn-outline" href="<?= url('admin') ?>">Batal</a>
        </div>
    </form>
</section>
