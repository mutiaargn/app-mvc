<section class="section admin">
    <span class="eyebrow">PANEL PENGELOLAAN</span>
    <h1>Dashboard Admin</h1>
    <p>Selamat datang, <?= e($_SESSION['admin_name'] ?? '') ?>. · <a href="<?= url('admin/gantiPassword') ?>">Ganti password</a></p>

    <?php if (!empty($passwordDefault)): ?>
        <div class="flash flash-warning" role="alert">
            Anda masih memakai password bawaan. <a href="<?= url('admin/gantiPassword') ?>">Ganti sekarang</a> sebelum aplikasi dipublikasikan.
        </div>
    <?php endif; ?>

    <div class="stats">
        <div><strong><?= count($wisata) ?></strong><span>Destinasi wisata</span></div>
        <div><strong><?= count($artikel) ?></strong><span>Artikel edukasi</span></div>
    </div>

    <div class="admin-head"><h2>Data wisata</h2><a class="btn" href="<?= url('admin/tambahWisata') ?>">+ Tambah wisata</a></div>
    <div class="table-wrap">
        <table>
            <tr><th>Nama</th><th>Lokasi</th><th>Kategori</th><th>Tiket</th><th>Aksi</th></tr>
            <?php foreach ($wisata as $w): ?>
                <tr>
                    <td><?= e($w['nama']) ?></td>
                    <td><?= e($w['lokasi']) ?></td>
                    <td><?= e($w['kategori']) ?></td>
                    <td><?= e(rupiah($w['harga_tiket'])) ?></td>
                    <td class="actions">
                        <a href="<?= url('wisata/detail/' . (int) $w['id']) ?>">Lihat</a>
                        <a href="<?= url('admin/editWisata/' . (int) $w['id']) ?>">Edit</a>
                        <form class="inline" method="post" action="<?= url('admin/hapusWisata/' . (int) $w['id']) ?>" data-confirm="Hapus wisata ini?">
                            <?= csrf_field() ?><button class="danger-link" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$wisata): ?><tr><td colspan="5">Belum ada data.</td></tr><?php endif; ?>
        </table>
    </div>

    <div class="admin-head"><h2>Artikel edukasi</h2><a class="btn" href="<?= url('admin/tambahEdukasi') ?>">+ Tambah artikel</a></div>
    <div class="table-wrap">
        <table>
            <tr><th>Judul</th><th>Tanggal</th><th>Aksi</th></tr>
            <?php foreach ($artikel as $a): ?>
                <tr>
                    <td><?= e($a['judul']) ?></td>
                    <td><?= e(tanggal_id($a['created_at'] ?? '')) ?></td>
                    <td class="actions">
                        <a href="<?= url('edukasi/detail/' . (int) $a['id']) ?>">Lihat</a>
                        <a href="<?= url('admin/editEdukasi/' . (int) $a['id']) ?>">Edit</a>
                        <form class="inline" method="post" action="<?= url('admin/hapusEdukasi/' . (int) $a['id']) ?>" data-confirm="Hapus artikel ini?">
                            <?= csrf_field() ?><button class="danger-link" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$artikel): ?><tr><td colspan="3">Belum ada data.</td></tr><?php endif; ?>
        </table>
    </div>
</section>
