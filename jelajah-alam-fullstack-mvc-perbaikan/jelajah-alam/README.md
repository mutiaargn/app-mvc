# Jelajah Alam

Aplikasi wisata alam dan edukasi lingkungan berbasis PHP native, MySQL, HTML, CSS, JavaScript dengan pola MVC.

## Kebutuhan
- PHP 8.0+ (ekstensi PDO MySQL dan mbstring aktif)
- MySQL 5.7+ atau MariaDB
- Apache dengan `mod_rewrite` (disarankan XAMPP)

## Cara menjalankan
1. Ekstrak folder `jelajah-alam` ke `C:/xampp/htdocs/`.
2. Jalankan Apache dan MySQL dari XAMPP.
3. Buka phpMyAdmin → Import → pilih `database/jelajah_alam.sql`.
   (File ini menghapus & membuat ulang tabel. Jika database lama sudah terlanjur diimpor dan ingin dipertahankan, jalankan `database/perbaikan_database_lama.sql` saja.)
4. Periksa `config/config.php`. Default XAMPP: host `localhost`, database `jelajah_alam`, user `root`, password kosong.
5. Buka `http://localhost/jelajah-alam/` (atau `http://localhost/jelajah-alam/public`).

`BASE_URL` terdeteksi otomatis, jadi tidak perlu diubah walau nama folder/port berbeda.
Jika URL cantik (mis. `/wisata`) tidak jalan, pastikan `mod_rewrite` aktif dan `AllowOverride All` di konfigurasi Apache.

## Login admin demo
- Username: `admin`
- Password: `password`

Setelah login, dashboard akan mengingatkan untuk **Ganti password** (menu di dashboard). Lakukan sebelum aplikasi dipublikasikan.

## Fitur
**Publik:** beranda, daftar wisata (cari, filter kategori, pagination), detail wisata (tautan Google Maps, wisata terkait), daftar & detail artikel edukasi (cari, pagination), halaman 404/500 yang rapi.

**Admin:** login, dashboard, tambah/edit/hapus wisata, tambah/edit/hapus artikel edukasi, ganti password, pesan notifikasi (flash), validasi formulir dengan pesan per kolom.

## Keamanan
Prepared statements (PDO), password hashing, `session_regenerate_id`, token CSRF di semua form (termasuk logout & hapus), cookie sesi `HttpOnly` + `SameSite`, validasi server (kategori whitelist, URL gambar hanya http/https), output di-escape, pembatasan login (5 gagal / 15 menit per IP), header keamanan dasar, folder `app/`, `config/`, `database/` diblokir dari akses browser, detail error tidak ditampilkan ke pengunjung (ditulis ke log PHP).

Catatan produksi: aktifkan HTTPS, buat user MySQL khusus (bukan `root`), dan atur kredensial lewat environment variable `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`. Jika di balik proxy/CDN, alamat IP pembatas login perlu disesuaikan.

## Struktur MVC
- `app/models`: query dan akses database
- `app/views`: antarmuka pengguna (`layout/` berisi header, footer, kartu, pagination)
- `app/controllers`: logika alur aplikasi
- `app/core`: Database, Model, Controller, helpers
- `config`: konfigurasi aplikasi
- `public`: front controller (`index.php`), aset, dan routing (`.htaccess`)
- `database`: skema dan data awal

## Belum tersedia (ide pengembangan)
Upload gambar lokal (saat ini memakai URL gambar), banyak akun admin/peran, dan editor teks kaya untuk artikel.
