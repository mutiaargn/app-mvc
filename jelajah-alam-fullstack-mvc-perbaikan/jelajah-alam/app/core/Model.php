<?php
require_once __DIR__ . '/Database.php';

class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /** Escape karakter khusus LIKE (%, _) agar pencarian literal. Pakai dengan: LIKE ? ESCAPE '!' */
    protected function escapeLike(string $text): string
    {
        return str_replace(['!', '%', '_'], ['!!', '!%', '!_'], $text);
    }

    /** Eksekusi query dengan parameter posisi; $ints berisi parameter terakhir bertipe integer (LIMIT/OFFSET). */
    protected function run(string $sql, array $params = [], array $ints = []): PDOStatement
    {
        $q = $this->db->prepare($sql);
        $i = 1;
        foreach ($params as $p) {
            $q->bindValue($i++, $p);
        }
        foreach ($ints as $n) {
            $q->bindValue($i++, (int) $n, PDO::PARAM_INT);
        }
        $q->execute();
        return $q;
    }
}
