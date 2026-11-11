<?php
require_once __DIR__ . '/../core/Model.php';

class User extends Model
{
    public const MAX_FAILURES   = 5;     // gagal login maksimum
    public const WINDOW_SECONDS = 900;   // dalam 15 menit

    public function find(int $id)
    {
        return $this->run('SELECT * FROM users WHERE id = ?', [$id])->fetch();
    }

    public function findByUsername(string $username)
    {
        return $this->run('SELECT * FROM users WHERE username = ?', [$username])->fetch();
    }

    public function updatePassword(int $id, string $hash): bool
    {
        $this->run('UPDATE users SET password = ? WHERE id = ?', [$hash, $id]);
        return true;
    }

    /* ---- Pembatasan percobaan login (per alamat IP) ---- */

    public function recentFailures(string $ip): int
    {
        $since = date('Y-m-d H:i:s', time() - self::WINDOW_SECONDS);
        return (int) $this->run('SELECT COUNT(*) FROM login_attempts WHERE ip = ? AND created_at > ?', [$ip, $since])->fetchColumn();
    }

    public function recordFailure(string $ip): void
    {
        $this->run('INSERT INTO login_attempts (ip, created_at) VALUES (?, ?)', [$ip, date('Y-m-d H:i:s')]);
        // Bersihkan catatan lama agar tabel tidak membengkak.
        $this->run('DELETE FROM login_attempts WHERE created_at < ?', [date('Y-m-d H:i:s', time() - 86400)]);
    }

    public function clearFailures(string $ip): void
    {
        $this->run('DELETE FROM login_attempts WHERE ip = ?', [$ip]);
    }
}
