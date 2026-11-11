<?php
require_once __DIR__ . '/helpers.php';

class Controller
{
    /** Render view di dalam layout (header + footer). */
    protected function view(string $file, array $data = [], ?string $title = null): void
    {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);

        $pageTitle = $title ? $title . ' · ' . APP_NAME : APP_NAME . ' — Wisata Alam & Edukasi Lingkungan';
        $section   = $this->currentSection();

        extract($data, EXTR_SKIP);
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/' . $file . '.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    /** Tampilkan halaman error (404, 405, 419, 429, 500, ...). */
    public function error(int $code, string $message = ''): void
    {
        http_response_code($code);
        $this->view('errors/error', ['code' => $code, 'message' => $message], 'Error ' . $code);
    }

    protected function redirect(string $path = ''): void
    {
        header('Location: ' . url($path));
        exit;
    }

    protected function flash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'msg' => $message];
    }

    protected function isPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
    }

    /** Ambil input POST sebagai string yang sudah di-trim (array diabaikan). */
    protected function input(string $key): string
    {
        $v = $_POST[$key] ?? '';
        return is_string($v) ? trim($v) : '';
    }

    /** Ambil parameter GET sebagai string yang sudah di-trim. */
    protected function query(string $key): string
    {
        $v = $_GET[$key] ?? '';
        return is_string($v) ? trim($v) : '';
    }

    /** Hentikan request jika token CSRF tidak cocok. */
    protected function verifyCsrf(): void
    {
        $sent = $_POST['csrf'] ?? '';
        if (!is_string($sent) || !hash_equals($_SESSION['csrf'] ?? '', $sent)) {
            $this->error(419, 'Sesi formulir kedaluwarsa. Muat ulang halaman lalu coba lagi.');
            exit;
        }
    }

    /** Hitung halaman: mengembalikan [halaman, totalHalaman, offset]. */
    protected function paginate(int $total, int $perPage): array
    {
        $pages = max(1, (int) ceil($total / $perPage));
        $page  = min($pages, max(1, (int) ($_GET['page'] ?? 1)));
        return [$page, $pages, ($page - 1) * $perPage];
    }

    private function currentSection(): string
    {
        $url = $_GET['url'] ?? '';
        $url = is_string($url) ? trim($url, '/') : '';
        return $url === '' ? 'home' : explode('/', $url)[0];
    }
}
