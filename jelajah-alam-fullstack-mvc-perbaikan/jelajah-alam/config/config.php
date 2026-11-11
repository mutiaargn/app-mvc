<?php
/**
 * Konfigurasi aplikasi Jelajah Alam.
 * Nilai bisa diubah langsung di sini atau lewat environment variable.
 */

define('APP_NAME', 'Jelajah Alam');

// Setel true HANYA saat pengembangan agar detail error tampil. Jangan aktifkan di server publik.
defined('APP_DEBUG') || define('APP_DEBUG', false);

date_default_timezone_set('Asia/Jakarta');

// Gambar cadangan jika gambar wisata kosong / gagal dimuat.
define('FALLBACK_IMG', 'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?w=900');

/*
 * BASE_URL dideteksi otomatis (mis. http://localhost/jelajah-alam/public).
 * Jika deteksi tidak cocok (misalnya di balik proxy), isi manual tanpa garis miring di akhir:
 *   $baseUrlManual = 'https://contoh.com';
 */
$baseUrlManual = '';
if (!defined('BASE_URL')) {
    if ($baseUrlManual !== '') {
        define('BASE_URL', rtrim($baseUrlManual, '/'));
    } else {
        $https  = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $folder = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
        define('BASE_URL', ($https ? 'https' : 'http') . '://' . $host . $folder);
    }
}

// Database (default XAMPP). Bisa ditimpa dengan environment variable DB_HOST, DB_NAME, DB_USER, DB_PASS.
defined('DB_HOST') || define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
defined('DB_NAME') || define('DB_NAME', getenv('DB_NAME') ?: 'jelajah_alam');
defined('DB_USER') || define('DB_USER', getenv('DB_USER') ?: 'root');
defined('DB_PASS') || define('DB_PASS', getenv('DB_PASS') !== false ? getenv('DB_PASS') : '');

// Jumlah item per halaman.
define('PER_PAGE_WISATA', 9);
define('PER_PAGE_EDUKASI', 9);
