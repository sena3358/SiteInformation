<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

Flight::set('flight.log_errors', true);

Flight::route('/', function (): void {
    $dbHost = getenv('DB_HOST') ?: 'db';
    $dbPort = getenv('DB_PORT') ?: '5432';
    $dbName = getenv('DB_NAME') ?: 'newsdb';
    $dbUser = getenv('DB_USER') ?: 'newsuser';
    $dbPass = getenv('DB_PASSWORD') ?: 'newspass';

    try {
        $dsn = "pgsql:host={$dbHost};port={$dbPort};dbname={$dbName}";
        $pdo = new PDO($dsn, $dbUser, $dbPass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        $statement = $pdo->query('SELECT NOW() AS current_time');
        $currentTime = $statement ? $statement->fetchColumn() : 'n/a';

        Flight::json([
            'status' => 'ok',
            'message' => 'Flight + PostgreSQL environment is running',
            'db_time' => $currentTime,
        ]);
    } catch (Throwable $e) {
        Flight::json([
            'status' => 'error',
            'message' => 'Database connection failed',
            'details' => $e->getMessage(),
        ], 500);
    }
});

Flight::start();
