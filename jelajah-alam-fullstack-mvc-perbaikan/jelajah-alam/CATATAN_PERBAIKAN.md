# Catatan Perbaikan

## Bug yang diperbaiki
1. **Login admin tidak bisa** — hash password di SQL salah (tidak cocok dengan "password"). Diganti hash yang valid.
2. **Semua URL (`/wisata`, `/edukasi`, dst.) selalu membuka beranda** — `.htaccess` tidak meneruskan parameter `url` ke `index.php`. Diperbaiki.
3. **Artikel menampilkan teks `\n\n` apa adanya** — di SQL tertulis `\\n`. Diganti baris baru yang benar.
4. **Dropdown kategori tidak terpilih saat edit wisata** — sekarang terpilih sesuai data.
5. **URL tanpa ID (mis. `/wisata/detail`) menyebabkan error fatal** — sekarang menampilkan 404.
6. Form yang gagal validasi tidak lagi menghilangkan isian pengguna.

## Fitur yang dilengkapi
- Edit artikel edukasi (sebelumnya hanya tambah & hapus; README menyebut belum ada)
- Ganti password + peringatan di dashboard bila masih memakai password bawaan
- Pencarian & pagination wisata dan edukasi; filter kategori wisata
- Validasi server untuk semua form dengan pesan per kolom
- Pesan notifikasi (berhasil/gagal), halaman error 404/405/419/429/500
- Judul halaman per-halaman, favicon, tautan "lewati ke konten", Google Maps, wisata terkait, tanggal artikel
- Harga 0 tampil "Gratis"; gambar cadangan otomatis jika URL gambar rusak

## Keamanan
- Logout dan hapus hanya via POST + CSRF
- Pembatasan percobaan login (tabel `login_attempts`)
- Cookie sesi HttpOnly/SameSite, header keamanan, proteksi folder internal, log error tanpa bocor ke pengunjung
- Pencarian meng-escape karakter `%` dan `_`; input array tidak lagi bisa memicu error
- `BASE_URL` otomatis; kredensial DB bisa lewat environment variable

## Cara memperbarui database lama
Jalankan `database/perbaikan_database_lama.sql` di phpMyAdmin (tidak menghapus data).
