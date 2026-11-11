<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle) ?></title>
<meta name="description" content="Jelajahi destinasi wisata alam Indonesia dan pelajari cara menjaga lingkungan.">
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%F0%9F%8C%BF%3C/text%3E%3C/svg%3E">
<link rel="stylesheet" href="<?= url('assets/css/style.css') ?>">
</head>
<body>
<a class="skip-link" href="#main">Lewati ke konten</a>
<header class="navbar">
    <a class="brand" href="<?= url() ?>">Jelajah<span>Alam.</span></a>
    <button class="menu-toggle" id="menuToggle" aria-label="Buka menu" aria-expanded="false" aria-controls="nav">☰</button>
    <nav id="nav" aria-label="Navigasi utama">
        <a href="<?= url() ?>"<?= $section === 'home' ? ' class="active"' : '' ?>>Beranda</a>
        <a href="<?= url('wisata') ?>"<?= $section === 'wisata' ? ' class="active"' : '' ?>>Wisata</a>
        <a href="<?= url('edukasi') ?>"<?= $section === 'edukasi' ? ' class="active"' : '' ?>>Edukasi</a>
        <?php if (!empty($_SESSION['admin_id'])): ?>
            <a href="<?= url('admin') ?>"<?= $section === 'admin' ? ' class="active"' : '' ?>>Dashboard</a>
            <form class="nav-form" method="post" action="<?= url('auth/logout') ?>">
                <?= csrf_field() ?>
                <button type="submit">Keluar</button>
            </form>
        <?php else: ?>
            <a href="<?= url('auth/login') ?>"<?= $section === 'auth' ? ' class="active"' : '' ?>>Admin</a>
        <?php endif; ?>
    </nav>
</header>
<main id="main">
<?php if (!empty($flash)): ?>
    <div class="flash flash-<?= e($flash['type']) ?>" role="status"><?= e($flash['msg']) ?></div>
<?php endif; ?>
