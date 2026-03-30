<?php

declare(strict_types=1);

require_once __DIR__ . '/../common/ResponseService.php';
require_once __DIR__ . '/../../models/AdminUser.php';

final class VisitorAuthService
{
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['visitor_user']) && is_array($_SESSION['visitor_user']);
    }

    public static function currentName(): string
    {
        if (!self::isLoggedIn()) {
            return '';
        }

        $username = $_SESSION['visitor_user']['username'] ?? '';
        return is_string($username) ? $username : '';
    }

    public static function requireLogin(): void
    {
        if (!self::isLoggedIn()) {
            self::setFlash('error', 'Veuillez vous connecter pour acceder a cette page.');
            ResponseService::redirect('/login');
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

        $role = strtolower((string) ($user['role'] ?? 'visitor'));
        if ($role !== 'visitor') {
            return false;
        }

        if (!self::isPasswordHash($storedPassword)) {
            AdminUser::updatePasswordById((int) $user['id'], password_hash($password, PASSWORD_DEFAULT));
        }

        session_regenerate_id(true);
        $_SESSION['visitor_user'] = [
            'id' => (int) $user['id'],
            'username' => (string) $user['username'],
            'role' => (string) ($user['role'] ?? 'visitor'),
        ];

        return true;
    }

    public static function logout(): void
    {
        unset($_SESSION['visitor_user']);
        session_regenerate_id(true);
    }

    public static function setFlash(string $type, string $message): void
    {
        $_SESSION['visitor_flash'] = [
            'type' => $type,
            'message' => $message,
        ];
    }

    /** @return array{type:string,message:string}|null */
    public static function popFlash(): ?array
    {
        if (!isset($_SESSION['visitor_flash']) || !is_array($_SESSION['visitor_flash'])) {
            return null;
        }

        $flash = $_SESSION['visitor_flash'];
        unset($_SESSION['visitor_flash']);

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
