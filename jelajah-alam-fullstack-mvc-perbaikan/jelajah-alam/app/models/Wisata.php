<?php
require_once __DIR__ . '/../core/Model.php';

class Wisata extends Model
{
    public const KATEGORI = ['Air Terjun', 'Pegunungan', 'Pantai', 'Hutan', 'Danau', 'Lainnya'];

    private function where(string $keyword, string $kategori, array &$params): string
    {
        $where = [];
        if ($keyword !== '') {
            $where[] = "(nama LIKE ? ESCAPE '!' OR lokasi LIKE ? ESCAPE '!')";
            $like = '%' . $this->escapeLike($keyword) . '%';
            $params[] = $like;
            $params[] = $like;
        }
        if ($kategori !== '') {
            $where[] = 'kategori = ?';
            $params[] = $kategori;
        }
        return $where ? ' WHERE ' . implode(' AND ', $where) : '';
    }

    /** Daftar wisata; $limit null = semua. */
    public function all(string $keyword = '', string $kategori = '', ?int $limit = null, int $offset = 0): array
    {
        $params = [];
        $sql = 'SELECT * FROM wisata' . $this->where($keyword, $kategori, $params) . ' ORDER BY id DESC';
        $ints = [];
        if ($limit !== null) {
            $sql .= ' LIMIT ? OFFSET ?';
            $ints = [$limit, $offset];
        }
        return $this->run($sql, $params, $ints)->fetchAll();
    }

    public function count(string $keyword = '', string $kategori = ''): int
    {
        $params = [];
        $sql = 'SELECT COUNT(*) FROM wisata' . $this->where($keyword, $kategori, $params);
        return (int) $this->run($sql, $params)->fetchColumn();
    }

    public function find(int $id)
    {
        return $this->run('SELECT * FROM wisata WHERE id = ?', [$id])->fetch();
    }

    /** Wisata lain dengan kategori sama. */
    public function related(string $kategori, int $exceptId, int $limit = 3): array
    {
        return $this->run(
            'SELECT * FROM wisata WHERE kategori = ? AND id <> ? ORDER BY id DESC LIMIT ?',
            [$kategori, $exceptId],
            [$limit]
        )->fetchAll();
    }

    public function create(array $d): bool
    {
        $this->run(
            'INSERT INTO wisata (nama,lokasi,kategori,harga_tiket,deskripsi,gambar) VALUES (?,?,?,?,?,?)',
            [$d['nama'], $d['lokasi'], $d['kategori'], (int) $d['harga_tiket'], $d['deskripsi'], $d['gambar'] !== '' ? $d['gambar'] : null]
        );
        return true;
    }

    public function update(int $id, array $d): bool
    {
        $this->run(
            'UPDATE wisata SET nama=?,lokasi=?,kategori=?,harga_tiket=?,deskripsi=?,gambar=? WHERE id=?',
            [$d['nama'], $d['lokasi'], $d['kategori'], (int) $d['harga_tiket'], $d['deskripsi'], $d['gambar'] !== '' ? $d['gambar'] : null, $id]
        );
        return true;
    }

    public function delete(int $id): bool
    {
        $this->run('DELETE FROM wisata WHERE id = ?', [$id]);
        return true;
    }
}
