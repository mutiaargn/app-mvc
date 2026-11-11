<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Wisata.php';

class WisataController extends Controller
{
    public function index(): void
    {
        $keyword  = mb_substr($this->query('q'), 0, 100);
        $kategori = $this->query('kategori');
        if (!in_array($kategori, Wisata::KATEGORI, true)) {
            $kategori = '';
        }

        $model = new Wisata();
        $total = $model->count($keyword, $kategori);
        [$page, $pages, $offset] = $this->paginate($total, PER_PAGE_WISATA);

        $this->view('wisata/index', [
            'wisata'       => $model->all($keyword, $kategori, PER_PAGE_WISATA, $offset),
            'keyword'      => $keyword,
            'kategori'     => $kategori,
            'kategoriList' => Wisata::KATEGORI,
            'total'        => $total,
            'page'         => $page,
            'pages'        => $pages,
        ], 'Wisata Alam');
    }

    public function detail($id): void
    {
        $model = new Wisata();
        $item  = $model->find((int) $id);
        if (!$item) {
            $this->error(404, 'Destinasi wisata tidak ditemukan.');
            return;
        }
        $this->view('wisata/detail', [
            'item'    => $item,
            'related' => $model->related($item['kategori'], (int) $item['id'], 3),
        ], $item['nama']);
    }
}
