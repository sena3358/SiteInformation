<?php

declare(strict_types=1);

if (!function_exists('db')) {
    require_once __DIR__ . '/../config/database.php';
}

final class User
{
    /** @return list<array{id:int,username:string,role:string}> */
    public static function all(): array
    {
        $stmt = db()->query('SELECT id, username, role FROM users ORDER BY id ASC');
        /** @var list<array{id:int,username:string,role:string}> $rows */
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }
}
