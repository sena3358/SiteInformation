<?php

declare(strict_types=1);

require_once __DIR__ . '/../../services/frontoffice/VisitorAuthService.php';
require_once __DIR__ . '/../../services/backoffice/AuthService.php';
require_once __DIR__ . '/../../services/common/ResponseService.php';

final class VisitorAuthController
{
    public static function loginForm(): void
    {
        if (VisitorAuthService::isLoggedIn()) {
            ResponseService::redirect('/mon-compte');
        }

        $flash = VisitorAuthService::popFlash();
        require __DIR__ . '/../../views/frontoffice/visitor/login.php';
    }

    public static function login(): void
    {
        $username = self::postValue('username');
        $password = self::postValue('password');

        if (VisitorAuthService::login($username, $password)) {
            VisitorAuthService::setFlash('success', 'Connexion reussie.');
            ResponseService::redirect('/mon-compte');
        }

        if (AuthService::login($username, $password)) {
            AuthService::setFlash('success', 'Connexion backoffice reussie.');
            ResponseService::redirect('/admin');
        }

        VisitorAuthService::setFlash('error', 'Identifiants invalides.');
        ResponseService::redirect('/login');
    }

    public static function logout(): void
    {
        VisitorAuthService::logout();
        VisitorAuthService::setFlash('success', 'Vous etes deconnecte.');
        ResponseService::redirect('/login');
    }

    public static function account(): void
    {
        VisitorAuthService::requireLogin();

        $username = VisitorAuthService::currentName();
        require __DIR__ . '/../../views/frontoffice/visitor/account.php';
    }

    private static function postValue(string $key): string
    {
        $raw = filter_input(INPUT_POST, $key, FILTER_UNSAFE_RAW);
        return is_string($raw) ? trim($raw) : '';
    }
}
