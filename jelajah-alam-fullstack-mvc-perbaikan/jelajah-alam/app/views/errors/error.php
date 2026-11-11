<section class="auth-wrap error-page">
    <div class="panel">
        <span class="eyebrow">KESALAHAN <?= (int) $code ?></span>
        <h1><?= $code === 404 ? 'Halaman tidak ditemukan' : 'Terjadi masalah' ?></h1>
        <p><?= e($message) ?></p>
        <a class="btn" href="<?= url() ?>">Kembali ke beranda</a>
    </div>
</section>
