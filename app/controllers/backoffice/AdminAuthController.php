<?php

declare(strict_types=1);

require_once __DIR__ . '/../../services/backoffice/AuthService.php';
require_once __DIR__ . '/../../services/frontoffice/VisitorAuthService.php';
require_once __DIR__ . '/../../services/common/ResponseService.php';
require_once __DIR__ . '/../../services/backoffice/ViewService.php';

final class AdminAuthController
{
    public static function loginForm(): void
    {
        if (AuthService::isLoggedIn()) {
            ResponseService::redirect('/admin');
        }

        ViewService::render('BackOffice - Connexion', 'admin/login');
    }

    public static function login(): void
    {
        $username = self::postValue('username');
        $password = self::postValue('password');

        if (AuthService::login($username, $password)) {
            AuthService::setFlash('success', 'Connexion reussie.');
            ResponseService::redirect('/admin');
        }

        if (VisitorAuthService::login($username, $password)) {
            VisitorAuthService::setFlash('success', 'Connexion visiteur reussie.');
            ResponseService::redirect('/mon-compte');
        }

        AuthService::setFlash('error', 'Nom utilisateur ou mot de passe incorrect.');
        ResponseService::redirect('/admin/login');
    }

    public static function logout(): void
    {
        AuthService::logout();
        AuthService::setFlash('success', 'Vous etes deconnecte.');
        ResponseService::redirect('/home');
    }

    private static function postValue(string $key): string
    {
        $raw = filter_input(INPUT_POST, $key, FILTER_UNSAFE_RAW);
        return is_string($raw) ? trim($raw) : '';
    }
}
