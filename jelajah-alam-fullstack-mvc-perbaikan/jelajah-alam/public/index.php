<?php
/** Front controller: semua request masuk lewat sini (lihat .htaccess). */

ob_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/core/helpers.php';
require_once __DIR__ . '/../app/core/Controller.php';
foreach (['Home', 'Wisata', 'Edukasi', 'Auth', 'Admin'] as $name) {
    require_once __DIR__ . "/../app/controllers/{$name}Controller.php";
}

// Header keamanan dasar.
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Sesi dengan cookie yang lebih aman.
$isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'secure'   => $isHttps,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

// Error tak terduga -> halaman 500 yang ramah (detail hanya ditulis ke log server).
set_exception_handler(function (Throwable $e) {
    error_log('[Jelajah Alam] ' . $e);
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    if (APP_DEBUG) {
        http_response_code(500);
        echo '<pre>' . e((string) $e) . '</pre>';
        return;
    }
    (new Controller())->error(500, 'Terjadi kesalahan pada server. Silakan coba lagi nanti.');
});

// Tabel rute: controller => [aksi => [kelas, method]]
$routes = [
    'home'    => ['index' => [HomeController::class, 'index']],
    'wisata'  => ['index' => [WisataController::class, 'index'], 'detail' => [WisataController::class, 'detail']],
    'edukasi' => ['index' => [EdukasiController::class, 'index'], 'detail' => [EdukasiController::class, 'detail']],
    'auth'    => ['login' => [AuthController::class, 'login'], 'logout' => [AuthController::class, 'logout']],
    'admin'   => [
        'index'          => [AdminController::class, 'index'],
        'tambahWisata'   => [AdminController::class, 'tambahWisata'],
        'editWisata'     => [AdminController::class, 'editWisata'],
        'hapusWisata'    => [AdminController::class, 'hapusWisata'],
        'tambahEdukasi'  => [AdminController::class, 'tambahEdukasi'],
        'editEdukasi'    => [AdminController::class, 'editEdukasi'],
        'hapusEdukasi'   => [AdminController::class, 'hapusEdukasi'],
        'gantiPassword'  => [AdminController::class, 'gantiPassword'],
    ],
];

$path     = isset($_GET['url']) && is_string($_GET['url']) ? trim($_GET['url'], '/') : '';
$segments = $path === '' ? [] : explode('/', $path);
$ctrl     = $segments[0] ?? 'home';
$action   = $segments[1] ?? 'index';
$args     = array_slice($segments, 2);

if (!isset($routes[$ctrl][$action])) {
    (new Controller())->error(404, 'Halaman yang Anda cari tidak ditemukan.');
    exit;
}

[$class, $method] = $routes[$ctrl][$action];
$ref = new ReflectionMethod($class, $method);
if (count($args) < $ref->getNumberOfRequiredParameters() || count($args) > $ref->getNumberOfParameters()) {
    (new Controller())->error(404, 'Halaman yang Anda cari tidak ditemukan.');
    exit;
}

(new $class())->$method(...$args);
