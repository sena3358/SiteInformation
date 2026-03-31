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

    /** @param array<string,mixed> $article */
    public static function article(array $article): string
    {
        $id = (int) ($article['id'] ?? 0);
        $title = (string) ($article['titre'] ?? 'article');
        return '/article-' . $id . '-' . slugify($title) . '.html';
    }

    /** @param array<string,mixed> $category */
    public static function category(array $category): string
    {
        $label = (string) ($category['libelle'] ?? 'categorie');
        return '/categorie-' . slugify($label) . '.html';
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

    public static function adminCategoriesCreate(): string
    {
        return '/admin/categories/create';
    }

    public static function adminCategoriesUpdate(int $id): string
    {
        return '/admin/categories/update/' . $id;
    }

    public static function adminCategoriesDelete(int $id): string
    {
        return '/admin/categories/delete/' . $id;
    }

    public static function adminArticlesDelete(int $id): string
    {
        return '/admin/articles/delete/' . $id;
    }
}
