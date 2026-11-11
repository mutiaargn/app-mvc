<article class="card">
    <img src="<?= e(img_src($w['gambar'])) ?>" alt="<?= e($w['nama']) ?>" loading="lazy"
         onerror="this.onerror=null;this.src='<?= e(FALLBACK_IMG) ?>'">
    <div class="card-body">
        <span class="tag"><?= e($w['kategori']) ?></span>
        <h3><?= e($w['nama']) ?></h3>
        <p>⌖ <?= e($w['lokasi']) ?></p>
        <p class="price"><?= e(rupiah($w['harga_tiket'])) ?></p>
        <a href="<?= url('wisata/detail/' . (int) $w['id']) ?>">Lihat detail →</a>
    </div>
</article>
