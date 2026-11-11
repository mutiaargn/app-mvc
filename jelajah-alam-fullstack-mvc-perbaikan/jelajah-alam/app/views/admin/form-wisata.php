<?php
$val = fn(string $k, string $default = '') => e($old[$k] ?? ($item[$k] ?? $default));
$selectedKategori = $old['kategori'] ?? ($item['kategori'] ?? '');
$action = $item ? url('admin/editWisata/' . (int) $item['id']) : url('admin/tambahWisata');
?>
<section class="auth-wrap">
    <form class="panel" method="post" action="<?= $action ?>" novalidate>
        <h1><?= $item ? 'Edit wisata' : 'Tambah wisata' ?></h1>
        <?= csrf_field() ?>

        <label for="nama">Nama wisata</label>
        <input id="nama" name="nama" required maxlength="150" value="<?= $val('nama') ?>">
        <?= field_error($errors, 'nama') ?>

        <label for="lokasi">Lokasi</label>
        <input id="lokasi" name="lokasi" required maxlength="180" value="<?= $val('lokasi') ?>">
        <?= field_error($errors, 'lokasi') ?>

        <label for="kategori">Kategori</label>
        <select id="kategori" name="kategori">
            <?php foreach ($kategoriList as $k): ?>
                <option value="<?= e($k) ?>"<?= $selectedKategori === $k ? ' selected' : '' ?>><?= e($k) ?></option>
            <?php endforeach; ?>
        </select>
        <?= field_error($errors, 'kategori') ?>

        <label for="harga_tiket">Harga tiket (Rp) — isi 0 jika gratis</label>
        <input id="harga_tiket" type="number" min="0" step="1" name="harga_tiket" value="<?= $val('harga_tiket', '0') ?>">
        <?= field_error($errors, 'harga_tiket') ?>

        <label for="gambar">URL gambar (opsional)</label>
        <input id="gambar" type="url" name="gambar" maxlength="500" placeholder="https://..." value="<?= $val('gambar') ?>">
        <?= field_error($errors, 'gambar') ?>

        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="6" required><?= $val('deskripsi') ?></textarea>
        <?= field_error($errors, 'deskripsi') ?>

        <div class="form-actions">
            <button class="btn" type="submit">Simpan</button>
            <a class="btn btn-outline" href="<?= url('admin') ?>">Batal</a>
        </div>
    </form>
</section>
