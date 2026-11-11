<?php
require_once __DIR__ . '/../core/Model.php';

class Edukasi extends Model
{
    private function where(string $keyword, array &$params): string
    {
        if ($keyword === '') {
            return '';
        }
        $like = '%' . $this->escapeLike($keyword) . '%';
        $params[] = $like;
        $params[] = $like;
        return " WHERE (judul LIKE ? ESCAPE '!' OR ringkasan LIKE ? ESCAPE '!')";
    }

    /** Daftar artikel; $limit null = semua. */
    public function all(string $keyword = '', ?int $limit = null, int $offset = 0): array
    {
        $params = [];
        $sql = 'SELECT * FROM edukasi' . $this->where($keyword, $params) . ' ORDER BY id DESC';
        $ints = [];
        if ($limit !== null) {
            $sql .= ' LIMIT ? OFFSET ?';
            $ints = [$limit, $offset];
        }
        return $this->run($sql, $params, $ints)->fetchAll();
    }

    public function count(string $keyword = ''): int
    {
        $params = [];
        $sql = 'SELECT COUNT(*) FROM edukasi' . $this->where($keyword, $params);
        return (int) $this->run($sql, $params)->fetchColumn();
    }

    public function find(int $id)
    {
        return $this->run('SELECT * FROM edukasi WHERE id = ?', [$id])->fetch();
    }

    public function create(array $d): bool
    {
        $this->run('INSERT INTO edukasi (judul,ringkasan,isi) VALUES (?,?,?)', [$d['judul'], $d['ringkasan'], $d['isi']]);
        return true;
    }

    public function update(int $id, array $d): bool
    {
        $this->run('UPDATE edukasi SET judul=?,ringkasan=?,isi=? WHERE id=?', [$d['judul'], $d['ringkasan'], $d['isi'], $id]);
        return true;
    }

    public function delete(int $id): bool
    {
        $this->run('DELETE FROM edukasi WHERE id = ?', [$id]);
        return true;
    }
}
