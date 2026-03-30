<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

final class HealthController
{
    public static function check(): void
    {
        try {
            $statement = db()->query('SELECT NOW() AS current_time');
            $currentTime = $statement ? $statement->fetchColumn() : 'n/a';

            app_json([
                'status' => 'ok',
                'message' => 'Application + PostgreSQL environment is running',
                'db_time' => $currentTime,
            ]);
        } catch (Throwable $e) {
            app_json([
                'status' => 'error',
                'message' => 'Database connection failed',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
