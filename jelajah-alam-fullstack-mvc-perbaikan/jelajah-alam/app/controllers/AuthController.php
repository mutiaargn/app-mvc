<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller
{
    /** Hash bcrypt palsu agar waktu respons sama baik username ada maupun tidak. */
    private const DUMMY_HASH = '$2y$10$qJvYgAp7KSnHHo429L7WdOQPLHwuoL8GJftT1FwPP/UvzG/sJ9CFK';

    public function login(): void
    {
        if (!empty($_SESSION['admin_id'])) {
            $this->redirect('admin');
        }

        if (!$this->isPost()) {
            $this->view('auth/login', [], 'Masuk Admin');
            return;
        }

        $this->verifyCsrf();

        $users    = new User();
        $ip       = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        $username = $this->input('username');
        $password = isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password'] : '';

        if ($users->recentFailures($ip) >= User::MAX_FAILURES) {
            http_response_code(429);
            $this->view('auth/login', [
                'error'    => 'Terlalu banyak percobaan gagal. Coba lagi dalam 15 menit.',
                'username' => $username,
            ], 'Masuk Admin');
            return;
        }

        $user = $users->findByUsername($username);
        $ok   = password_verify($password, $user['password'] ?? self::DUMMY_HASH) && $user;

        if ($ok) {
            $users->clearFailures($ip);
            session_regenerate_id(true);
            $_SESSION['admin_id']   = (int) $user['id'];
            $_SESSION['admin_name'] = $user['nama'];
            $this->flash('success', 'Selamat datang kembali, ' . $user['nama'] . '.');
            $this->redirect('admin');
        }

        $users->recordFailure($ip);
        http_response_code(401);
        $this->view('auth/login', [
            'error'    => 'Username atau password salah.',
            'username' => $username,
        ], 'Masuk Admin');
    }

    /** Logout hanya lewat POST + CSRF agar tidak bisa dipicu dari tautan/gambar pihak lain. */
    public function logout(): void
    {
        if (!$this->isPost()) {
            $this->redirect('');
        }
        $this->verifyCsrf();

        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();

        // Mulai sesi baru agar bisa menampilkan pesan dan token CSRF baru.
        session_start();
        session_regenerate_id(true);
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        $this->flash('success', 'Anda sudah keluar.');
        $this->redirect('');
    }
}
