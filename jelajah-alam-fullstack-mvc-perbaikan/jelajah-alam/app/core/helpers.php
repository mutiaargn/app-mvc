<?php
/** Fungsi bantu global untuk view dan controller. */

/** Escape output HTML. */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Bangun URL absolut dari path relatif. */
function url(string $path = ''): string
{
    return BASE_URL . ($path === '' ? '' : '/' . ltrim($path, '/'));
}

/** Format harga tiket. */
function rupiah($angka): string
{
    $angka = (int) $angka;
    return $angka === 0 ? 'Gratis' : 'Rp' . number_format($angka, 0, ',', '.');
}

/** Hanya izinkan URL gambar http/https; selain itu pakai gambar cadangan. */
function img_src($gambar): string
{
    $gambar = trim((string) $gambar);
    return preg_match('#^https?://#i', $gambar) ? $gambar : FALLBACK_IMG;
}

/** Tanggal dalam bahasa Indonesia, mis. 10 November 2026. */
function tanggal_id($datetime): string
{
    $ts = strtotime((string) $datetime);
    if (!$ts) {
        return '';
    }
    $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
              'September', 'Oktober', 'November', 'Desember'];
    return date('j', $ts) . ' ' . $bulan[(int) date('n', $ts)] . ' ' . date('Y', $ts);
}

/** Pesan error di bawah field formulir. */
function field_error(array $errors, string $key): string
{
    return empty($errors[$key]) ? '' : '<span class="field-error">' . e($errors[$key]) . '</span>';
}

/** Input hidden token CSRF. */
function csrf_field(): string
{
    return '<input type="hidden" name="csrf" value="' . e($_SESSION['csrf'] ?? '') . '">';
}
