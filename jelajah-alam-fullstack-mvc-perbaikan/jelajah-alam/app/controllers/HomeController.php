<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Wisata.php';
require_once __DIR__ . '/../models/Edukasi.php';

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home/index', [
            'wisata'  => (new Wisata())->all('', '', 3),
            'edukasi' => (new Edukasi())->all('', 3),
        ]);
    }
}
