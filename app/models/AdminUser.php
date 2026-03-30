<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

final class AdminUser
{
    /** @return array{id:int,username:string,password:string,role:string}|null */
    public static function findByUsername(string $username): ?array
    {
        $stmt = db()->prepare('SELECT id, username, password, role FROM users WHERE username = :username LIMIT 1');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!is_array($user)) {
            return null;
        }

        return [
            'id' => (int) $user['id'],
            'username' => (string) $user['username'],
            'password' => (string) $user['password'],
            'role' => (string) ($user['role'] ?? 'editor'),
        ];
    }

    public static function updatePasswordById(int $id, string $hash): void
    {
        $stmt = db()->prepare('UPDATE users SET password = :password WHERE id = :id');
        $stmt->execute([
            'password' => $hash,
            'id' => $id,
        ]);
    }
}
