<?php

declare(strict_types=1);

require_once __DIR__ . '/../common/ResponseService.php';
require_once __DIR__ . '/../../models/AdminUser.php';

final class AuthService
{
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['admin_user']) && is_array($_SESSION['admin_user']);
    }

    public static function currentAdminName(): string
    {
        if (!self::isLoggedIn()) {
            return '';
        }

        $username = $_SESSION['admin_user']['username'] ?? '';
        return is_string($username) ? $username : '';
    }

    public static function requireAdmin(): void
    {
        if (!self::isLoggedIn()) {
            self::setFlash('error', 'Veuillez vous connecter pour acceder au BackOffice.');
            ResponseService::redirect('/admin/login');
        }
    }

    public static function login(string $username, string $password): bool
    {
        if ($username === '' || $password === '') {
            return false;
        }

        $user = AdminUser::findByUsername($username);
        if ($user === null) {
            return false;
        }

        $storedPassword = (string) ($user['password'] ?? '');
        if (!self::verifyPassword($password, $storedPassword)) {
            return false;
        }

        $role = strtolower((string) ($user['role'] ?? 'editor'));
        if ($role === 'visitor') {
            return false;
        }

        if (!self::isPasswordHash($storedPassword)) {
            AdminUser::updatePasswordById((int) $user['id'], password_hash($password, PASSWORD_DEFAULT));
        }

        session_regenerate_id(true);
        $_SESSION['admin_user'] = [
            'id' => (int) $user['id'],
            'username' => (string) $user['username'],
            'role' => (string) ($user['role'] ?? 'editor'),
        ];

        return true;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        session_start();
    }

    public static function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    /** @return array{type: string, message: string}|null */
    public static function popFlash(): ?array
    {
        if (!isset($_SESSION['flash']) || !is_array($_SESSION['flash'])) {
            return null;
        }

        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);

        $type = isset($flash['type']) && is_string($flash['type']) ? $flash['type'] : 'info';
        $message = isset($flash['message']) && is_string($flash['message']) ? $flash['message'] : '';

        return ['type' => $type, 'message' => $message];
    }

    private static function isPasswordHash(string $value): bool
    {
        return str_starts_with($value, '$2y$')
            || str_starts_with($value, '$argon2i$')
            || str_starts_with($value, '$argon2id$');
    }

    private static function verifyPassword(string $enteredPassword, string $storedValue): bool
    {
        if (self::isPasswordHash($storedValue)) {
            return password_verify($enteredPassword, $storedValue);
        }

        return hash_equals($storedValue, $enteredPassword);
    }
}
