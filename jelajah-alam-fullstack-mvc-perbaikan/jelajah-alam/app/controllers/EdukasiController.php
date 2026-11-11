<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Edukasi.php';

class EdukasiController extends Controller
{
    public function index(): void
    {
        $keyword = mb_substr($this->query('q'), 0, 100);

        $model = new Edukasi();
        $total = $model->count($keyword);
        [$page, $pages, $offset] = $this->paginate($total, PER_PAGE_EDUKASI);

        $this->view('edukasi/index', [
            'artikel' => $model->all($keyword, PER_PAGE_EDUKASI, $offset),
            'keyword' => $keyword,
            'total'   => $total,
            'page'    => $page,
            'pages'   => $pages,
        ], 'Edukasi Lingkungan');
    }

    public function detail($id): void
    {
        $item = (new Edukasi())->find((int) $id);
        if (!$item) {
            $this->error(404, 'Artikel tidak ditemukan.');
            return;
        }
        $this->view('edukasi/detail', ['item' => $item], $item['judul']);
    }
}
