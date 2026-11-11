<section class="page-hero">
    <span class="eyebrow">JELAJAHI INDONESIA</span>
    <h1>Destinasi Wisata Alam</h1>
    <p>Pilih tempat, nikmati perjalanan, dan kenali keindahan alam.</p>
</section>

<section class="section">
    <form class="search" method="get" action="<?= url('wisata') ?>">
        <input name="q" placeholder="Cari nama wisata atau lokasi..." value="<?= e($keyword) ?>" maxlength="100" aria-label="Cari wisata">
        <?php if ($kategori !== ''): ?><input type="hidden" name="kategori" value="<?= e($kategori) ?>"><?php endif; ?>
        <button class="btn" type="submit">Cari</button>
    </form>

    <div class="chips" aria-label="Filter kategori">
        <a class="chip<?= $kategori === '' ? ' active' : '' ?>" href="<?= e(url('wisata') . ($keyword !== '' ? '?q=' . urlencode($keyword) : '')) ?>">Semua</a>
        <?php foreach ($kategoriList as $k): ?>
            <a class="chip<?= $kategori === $k ? ' active' : '' ?>"
               href="<?= e(url('wisata') . '?' . http_build_query(array_filter(['q' => $keyword, 'kategori' => $k]))) ?>"><?= e($k) ?></a>
        <?php endforeach; ?>
    </div>

    <p class="result-info"><?= (int) $total ?> destinasi ditemukan<?= $keyword !== '' ? ' untuk “' . e($keyword) . '”' : '' ?><?= $kategori !== '' ? ' di kategori ' . e($kategori) : '' ?>.</p>

    <div class="cards">
        <?php foreach ($wisata as $w): require __DIR__ . '/../layout/card-wisata.php'; endforeach; ?>
    </div>
    <?php if (!$wisata): ?><p class="empty">Belum ada wisata yang cocok dengan pencarian.</p><?php endif; ?>

    <?php $basePath = 'wisata'; $query = ['q' => $keyword, 'kategori' => $kategori]; require __DIR__ . '/../layout/pagination.php'; ?>
</section>
