<section class="section prose">
    <span class="eyebrow">EDUKASI ALAM</span>
    <h1><?= e($item['judul']) ?></h1>
    <?php if (!empty($item['created_at'])): ?><p class="meta">Dipublikasikan <?= e(tanggal_id($item['created_at'])) ?></p><?php endif; ?>
    <p class="lead"><?= e($item['ringkasan']) ?></p>
    <div><?= nl2br(e($item['isi'])) ?></div>
    <a href="<?= url('edukasi') ?>" class="text-link">← Kembali ke edukasi</a>
</section>
