-- Untuk database jelajah_alam yang SUDAH terlanjur diimpor dari versi lama.
-- Aman dijalankan tanpa menghapus data. Jalankan lewat phpMyAdmin (tab SQL) pada database jelajah_alam.

-- 1) Perbaiki hash password admin yang rusak (password sesudah ini: "password").
UPDATE users
   SET password = '$2y$10$53HqaHXtrInToOOV4f3Kxe5JgTg4zjCPxWsf1HvsABZ9IPAR6ZHKG'
 WHERE username = 'admin'
   AND password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.pe1Jt3/8e';

-- 2) Ubah teks "\n" literal pada artikel menjadi baris baru sungguhan.
UPDATE edukasi SET isi = REPLACE(isi, CONCAT(CHAR(92), 'n'), CHAR(10));

-- 3) Tabel pembatas percobaan login.
CREATE TABLE IF NOT EXISTS login_attempts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ip VARCHAR(45) NOT NULL,
  created_at DATETIME NOT NULL,
  INDEX idx_login_ip_time (ip, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
