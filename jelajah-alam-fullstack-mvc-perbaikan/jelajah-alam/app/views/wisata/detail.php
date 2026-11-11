<section class="section detail">
    <img class="detail-image" src="<?= e(img_src($item['gambar'])) ?>" alt="<?= e($item['nama']) ?>"
         onerror="this.onerror=null;this.src='<?= e(FALLBACK_IMG) ?>'">
    <span class="tag"><?= e($item['kategori']) ?></span>
    <h1><?= e($item['nama']) ?></h1>
    <p class="meta">⌖ <?= e($item['lokasi']) ?> · Tiket: <?= e(rupiah($item['harga_tiket'])) ?></p>
    <p><a class="btn btn-outline" target="_blank" rel="noopener noreferrer"
          href="https://www.google.com/maps/search/?api=1&amp;query=<?= e(urlencode($item['nama'] . ', ' . $item['lokasi'])) ?>">Lihat di Google Maps ↗</a></p>

    <h2>Tentang destinasi</h2>
    <p><?= nl2br(e($item['deskripsi'])) ?></p>

    <?php if ($related): ?>
        <h2 class="related-title">Wisata <?= e($item['kategori']) ?> lainnya</h2>
        <div class="cards">
            <?php foreach ($related as $w): require __DIR__ . '/../layout/card-wisata.php'; endforeach; ?>
        </div>
    <?php endif; ?>

    <a href="<?= url('wisata') ?>" class="text-link">← Kembali ke wisata</a>
</section>
