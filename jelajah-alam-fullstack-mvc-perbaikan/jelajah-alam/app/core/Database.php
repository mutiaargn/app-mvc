<?php
class Database
{
    private static $pdo;

    public static function connect(): PDO
    {
        if (!self::$pdo) {
            // DB_DSN bersifat opsional (mis. untuk pengujian); default memakai MySQL.
            $dsn = defined('DB_DSN')
                ? DB_DSN
                : 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';

            self::$pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        }
        return self::$pdo;
    }
}
