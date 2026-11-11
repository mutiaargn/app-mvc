<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Wisata.php';
require_once __DIR__ . '/../models/Edukasi.php';
require_once __DIR__ . '/../models/User.php';

class AdminController extends Controller
{
    private function guard(): void
    {
        if (empty($_SESSION['admin_id'])) {
            $this->flash('error', 'Silakan masuk terlebih dahulu.');
            $this->redirect('auth/login');
        }
    }

    /** Pastikan request berupa POST + CSRF valid (untuk aksi hapus). */
    private function requirePost(): void
    {
        if (!$this->isPost()) {
            $this->error(405, 'Metode tidak diizinkan.');
            exit;
        }
        $this->verifyCsrf();
    }

    /* ------------------------------------------------------------ Dashboard */

    public function index(): void
    {
        $this->guard();
        $user = (new User())->find((int) $_SESSION['admin_id']);

        $this->view('admin/index', [
            'wisata'          => (new Wisata())->all(),
            'artikel'         => (new Edukasi())->all(),
            // Peringatan jika admin masih memakai password bawaan.
            'passwordDefault' => $user && password_verify('password', $user['password']),
        ], 'Dashboard Admin');
    }

    /* --------------------------------------------------------------- Wisata */

    public function tambahWisata(): void
    {
        $this->guard();
        $old = [];
        $errors = [];

        if ($this->isPost()) {
            $this->verifyCsrf();
            [$data, $errors] = $this->validateWisata();
            if (!$errors) {
                (new Wisata())->create($data);
                $this->flash('success', 'Destinasi wisata berhasil ditambahkan.');
                $this->redirect('admin');
            }
            $old = $data;
            http_response_code(422);
        }

        $this->view('admin/form-wisata', [
            'item' => null, 'old' => $old, 'errors' => $errors, 'kategoriList' => Wisata::KATEGORI,
        ], 'Tambah Wisata');
    }

    public function editWisata($id): void
    {
        $this->guard();
        $model = new Wisata();
        $item  = $model->find((int) $id);
        if (!$item) {
            $this->error(404, 'Data wisata tidak ditemukan.');
            return;
        }

        $old = [];
        $errors = [];
        if ($this->isPost()) {
            $this->verifyCsrf();
            [$data, $errors] = $this->validateWisata();
            if (!$errors) {
                $model->update((int) $id, $data);
                $this->flash('success', 'Destinasi wisata berhasil diperbarui.');
                $this->redirect('admin');
            }
            $old = $data;
            http_response_code(422);
        }

        $this->view('admin/form-wisata', [
            'item' => $item, 'old' => $old, 'errors' => $errors, 'kategoriList' => Wisata::KATEGORI,
        ], 'Edit Wisata');
    }

    public function hapusWisata($id): void
    {
        $this->guard();
        $this->requirePost();
        (new Wisata())->delete((int) $id);
        $this->flash('success', 'Destinasi wisata dihapus.');
        $this->redirect('admin');
    }

    /* -------------------------------------------------------------- Edukasi */

    public function tambahEdukasi(): void
    {
        $this->guard();
        $old = [];
        $errors = [];

        if ($this->isPost()) {
            $this->verifyCsrf();
            [$data, $errors] = $this->validateEdukasi();
            if (!$errors) {
                (new Edukasi())->create($data);
                $this->flash('success', 'Artikel edukasi berhasil dipublikasikan.');
                $this->redirect('admin');
            }
            $old = $data;
            http_response_code(422);
        }

        $this->view('admin/form-edukasi', ['item' => null, 'old' => $old, 'errors' => $errors], 'Tambah Artikel');
    }

    public function editEdukasi($id): void
    {
        $this->guard();
        $model = new Edukasi();
        $item  = $model->find((int) $id);
        if (!$item) {
            $this->error(404, 'Artikel tidak ditemukan.');
            return;
        }

        $old = [];
        $errors = [];
        if ($this->isPost()) {
            $this->verifyCsrf();
            [$data, $errors] = $this->validateEdukasi();
            if (!$errors) {
                $model->update((int) $id, $data);
                $this->flash('success', 'Artikel berhasil diperbarui.');
                $this->redirect('admin');
            }
            $old = $data;
            http_response_code(422);
        }

        $this->view('admin/form-edukasi', ['item' => $item, 'old' => $old, 'errors' => $errors], 'Edit Artikel');
    }

    public function hapusEdukasi($id): void
    {
        $this->guard();
        $this->requirePost();
        (new Edukasi())->delete((int) $id);
        $this->flash('success', 'Artikel edukasi dihapus.');
        $this->redirect('admin');
    }

    /* ------------------------------------------------------- Ganti password */

    public function gantiPassword(): void
    {
        $this->guard();
        $errors = [];

        if ($this->isPost()) {
            $this->verifyCsrf();
            $users   = new User();
            $user    = $users->find((int) $_SESSION['admin_id']);
            $current = isset($_POST['current']) && is_string($_POST['current']) ? $_POST['current'] : '';
            $new     = isset($_POST['new']) && is_string($_POST['new']) ? $_POST['new'] : '';
            $confirm = isset($_POST['confirm']) && is_string($_POST['confirm']) ? $_POST['confirm'] : '';

            if (!$user || !password_verify($current, $user['password'])) {
                $errors['current'] = 'Password saat ini salah.';
            }
            if (mb_strlen($new) < 8) {
                $errors['new'] = 'Password baru minimal 8 karakter.';
            } elseif ($new === 'password') {
                $errors['new'] = 'Jangan memakai password bawaan.';
            }
            if ($new !== $confirm) {
                $errors['confirm'] = 'Konfirmasi password tidak sama.';
            }

            if (!$errors) {
                $users->updatePassword((int) $user['id'], password_hash($new, PASSWORD_DEFAULT));
                session_regenerate_id(true);
                $this->flash('success', 'Password berhasil diganti.');
                $this->redirect('admin');
            }
            http_response_code(422);
        }

        $this->view('admin/ganti-password', ['errors' => $errors], 'Ganti Password');
    }

    /* ------------------------------------------------------------- Validasi */

    /** Kembalikan [data, errors]. Data selalu berisi input yang sudah dibersihkan agar form bisa diisi ulang. */
    private function validateWisata(): array
    {
        $d = [
            'nama'        => $this->input('nama'),
            'lokasi'      => $this->input('lokasi'),
            'kategori'    => $this->input('kategori'),
            'harga_tiket' => $this->input('harga_tiket'),
            'gambar'      => $this->input('gambar'),
            'deskripsi'   => $this->input('deskripsi'),
        ];
        $e = [];

        $len = mb_strlen($d['nama']);
        if ($len < 3 || $len > 150) {
            $e['nama'] = 'Nama wisata harus 3–150 karakter.';
        }
        $len = mb_strlen($d['lokasi']);
        if ($len < 3 || $len > 180) {
            $e['lokasi'] = 'Lokasi harus 3–180 karakter.';
        }
        if (!in_array($d['kategori'], Wisata::KATEGORI, true)) {
            $e['kategori'] = 'Pilih kategori yang tersedia.';
        }
        if ($d['harga_tiket'] === '') {
            $d['harga_tiket'] = '0';
        }
        if (!ctype_digit($d['harga_tiket']) || strlen($d['harga_tiket']) > 9) {
            $e['harga_tiket'] = 'Harga tiket harus berupa angka bulat 0 atau lebih.';
        }
        if ($d['gambar'] !== '') {
            $scheme = strtolower((string) parse_url($d['gambar'], PHP_URL_SCHEME));
            if (!filter_var($d['gambar'], FILTER_VALIDATE_URL) || !in_array($scheme, ['http', 'https'], true) || strlen($d['gambar']) > 500) {
                $e['gambar'] = 'URL gambar harus diawali http:// atau https:// (maksimal 500 karakter).';
            }
        }
        if (mb_strlen($d['deskripsi']) < 20) {
            $e['deskripsi'] = 'Deskripsi minimal 20 karakter.';
        }

        return [$d, $e];
    }

    private function validateEdukasi(): array
    {
        $d = [
            'judul'     => $this->input('judul'),
            'ringkasan' => $this->input('ringkasan'),
            'isi'       => $this->input('isi'),
        ];
        $e = [];

        $len = mb_strlen($d['judul']);
        if ($len < 5 || $len > 180) {
            $e['judul'] = 'Judul harus 5–180 karakter.';
        }
        $len = mb_strlen($d['ringkasan']);
        if ($len < 10 || $len > 500) {
            $e['ringkasan'] = 'Ringkasan harus 10–500 karakter.';
        }
        if (mb_strlen($d['isi']) < 30) {
            $e['isi'] = 'Isi artikel minimal 30 karakter.';
        }

        return [$d, $e];
    }
}
