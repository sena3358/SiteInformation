<?php

declare(strict_types=1);

final class DatabaseService
{
    public static function connection(): PDO
    {
        static $pdo = null;

        if ($pdo instanceof PDO) {
            return $pdo;
        }

        $dbHost = getenv('DB_HOST') ?: 'db';
        $dbPort = getenv('DB_PORT') ?: '5432';
        $dbName = getenv('DB_NAME') ?: 'newsdb';
        $dbUser = getenv('DB_USER') ?: 'newsuser';
        $dbPass = getenv('DB_PASSWORD') ?: 'newspass';

        $dsn = "pgsql:host={$dbHost};port={$dbPort};dbname={$dbName}";
        $pdo = new PDO($dsn, $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        return $pdo;
    }
}
