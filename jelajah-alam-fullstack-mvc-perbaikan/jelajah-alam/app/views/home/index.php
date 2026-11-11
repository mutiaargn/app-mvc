<section class="hero">
    <div class="hero-content">
        <span class="eyebrow">EXPLORE • LEARN • PRESERVE</span>
        <h1>Temukan Keindahan<br><em>Alam Indonesia.</em></h1>
        <p>Jelajahi destinasi alam dan temukan pengetahuan baru tentang lingkungan di sekitar kita.</p>
        <a class="btn" href="<?= url('wisata') ?>">Jelajahi Wisata</a>
    </div>
</section>

<section class="section">
    <div class="section-heading">
        <div><span class="eyebrow">DESTINASI PILIHAN</span><h2>Wisata alam</h2></div>
        <a href="<?= url('wisata') ?>">Lihat semua →</a>
    </div>
    <div class="cards">
        <?php foreach ($wisata as $w): require __DIR__ . '/../layout/card-wisata.php'; endforeach; ?>
    </div>
    <?php if (!$wisata): ?><p class="empty">Belum ada destinasi wisata.</p><?php endif; ?>
</section>

<section class="education-band">
    <div>
        <span class="eyebrow">BELAJAR DARI ALAM</span>
        <h2>Alam bukan hanya untuk dinikmati, tetapi juga untuk dipahami.</h2>
        <p>Pelajari ekosistem, keanekaragaman hayati, dan cara menjaga lingkungan.</p>
        <a class="btn btn-light" href="<?= url('edukasi') ?>">Baca edukasi</a>
    </div>
</section>

<section class="section">
    <div class="section-heading">
        <div><span class="eyebrow">WAWASAN LINGKUNGAN</span><h2>Artikel edukasi</h2></div>
        <a href="<?= url('edukasi') ?>">Lihat semua →</a>
    </div>
    <div class="article-list">
        <?php foreach ($edukasi as $a): ?>
            <article>
                <span class="tag">EDUKASI</span>
                <h3><?= e($a['judul']) ?></h3>
                <p><?= e($a['ringkasan']) ?></p>
                <a href="<?= url('edukasi/detail/' . (int) $a['id']) ?>">Baca selengkapnya →</a>
            </article>
        <?php endforeach; ?>
    </div>
    <?php if (!$edukasi): ?><p class="empty">Belum ada artikel.</p><?php endif; ?>
</section>
