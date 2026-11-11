<section class="page-hero">
    <span class="eyebrow">PENGETAHUAN LINGKUNGAN</span>
    <h1>Belajar dari Alam</h1>
    <p>Informasi sederhana untuk memahami dan menjaga bumi.</p>
</section>

<section class="section">
    <form class="search" method="get" action="<?= url('edukasi') ?>">
        <input name="q" placeholder="Cari artikel edukasi..." value="<?= e($keyword) ?>" maxlength="100" aria-label="Cari artikel">
        <button class="btn" type="submit">Cari</button>
    </form>
    <p class="result-info"><?= (int) $total ?> artikel ditemukan<?= $keyword !== '' ? ' untuk “' . e($keyword) . '”' : '' ?>.</p>

    <div class="article-list">
        <?php foreach ($artikel as $a): ?>
            <article>
                <span class="tag">EDUKASI ALAM</span>
                <h2><?= e($a['judul']) ?></h2>
                <p><?= e($a['ringkasan']) ?></p>
                <a href="<?= url('edukasi/detail/' . (int) $a['id']) ?>">Baca selengkapnya →</a>
            </article>
        <?php endforeach; ?>
    </div>
    <?php if (!$artikel): ?><p class="empty">Belum ada artikel<?= $keyword !== '' ? ' yang cocok' : '' ?>.</p><?php endif; ?>

    <?php $basePath = 'edukasi'; $query = ['q' => $keyword]; require __DIR__ . '/../layout/pagination.php'; ?>
</section>
