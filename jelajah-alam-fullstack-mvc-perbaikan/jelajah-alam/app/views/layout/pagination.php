<?php
/** Butuh: $page, $pages, $basePath, $query (array parameter lain, mis. q/kategori). */
if ($pages > 1):
    $link = function (int $p) use ($basePath, $query) {
        $q = array_filter($query, fn($v) => $v !== '');
        if ($p > 1) {
            $q['page'] = $p;
        }
        return url($basePath) . ($q ? '?' . http_build_query($q) : '');
    };
?>
<nav class="pagination" aria-label="Halaman">
    <?php if ($page > 1): ?><a href="<?= e($link($page - 1)) ?>" rel="prev">← Sebelumnya</a><?php endif; ?>
    <?php for ($p = 1; $p <= $pages; $p++): ?>
        <?php if ($p === $page): ?><span class="current" aria-current="page"><?= $p ?></span>
        <?php else: ?><a href="<?= e($link($p)) ?>"><?= $p ?></a><?php endif; ?>
    <?php endfor; ?>
    <?php if ($page < $pages): ?><a href="<?= e($link($page + 1)) ?>" rel="next">Berikutnya →</a><?php endif; ?>
</nav>
<?php endif; ?>
