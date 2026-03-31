<?php

declare(strict_types=1);

/**
 * UrlHelper - Generates SEO-friendly URLs
 */
final class UrlHelper
{
    // Frontoffice URLs
    public static function home(): string
    {
        return '/home.html';
    }

    public static function login(): string
    {
        return '/login.html';
    }

    public static function logout(): string
    {
        return '/logout.html';
    }

    public static function account(): string
    {
        return '/mon-compte.html';
    }

    public static function users(): string
    {
        return '/users.html';
    }

    public static function usersForm(): string
    {
        return '/users-form.html';
    }

    // Backoffice URLs
    public static function adminLogin(): string
    {
        return '/admin-login.html';
    }

    public static function adminLogout(): string
    {
        return '/admin-deconnexion.html';
    }

    public static function admin(): string
    {
        return '/admin.html';
    }

    public static function adminArticles(): string
    {
        return '/admin-articles.html';
    }

    public static function adminArticlesCreate(): string
    {
        return '/admin-articles-create.html';
    }

    public static function adminArticlesEdit(int $id): string
    {
        return '/admin-articles-edit-' . $id . '.html';
    }

    public static function adminCategories(): string
    {
        return '/admin-categories.html';
    }
}
