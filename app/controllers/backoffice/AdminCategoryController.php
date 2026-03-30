<?php

declare(strict_types=1);

require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../services/backoffice/AuthService.php';
require_once __DIR__ . '/../../services/common/ResponseService.php';
require_once __DIR__ . '/../../services/backoffice/ViewService.php';

final class AdminCategoryController
{
    public static function index(): void
    {
        AuthService::requireAdmin();
        ViewService::render('BackOffice - Categories', 'admin/categories', [
            'categories' => Category::all(),
        ]);
    }

    public static function create(): void
    {
        AuthService::requireAdmin();

        $libelle = self::postValue('libelle');
        if ($libelle === '') {
            AuthService::setFlash('error', 'Le libelle de categorie est obligatoire.');
            ResponseService::redirect('/admin/categories');
        }

        try {
            Category::create($libelle);
            AuthService::setFlash('success', 'Categorie creee.');
        } catch (Throwable $e) {
            AuthService::setFlash('error', 'Impossible de creer cette categorie (doublon probable).');
        }

        ResponseService::redirect('/admin/categories');
    }

    public static function update(string $id): void
    {
        AuthService::requireAdmin();

        $libelle = self::postValue('libelle');
        if ($libelle === '') {
            AuthService::setFlash('error', 'Le libelle de categorie est obligatoire.');
            ResponseService::redirect('/admin/categories');
        }

        Category::update((int) $id, $libelle);
        AuthService::setFlash('success', 'Categorie modifiee.');
        ResponseService::redirect('/admin/categories');
    }

    public static function delete(string $id): void
    {
        AuthService::requireAdmin();
        Category::delete((int) $id);
        AuthService::setFlash('success', 'Categorie supprimee.');
        ResponseService::redirect('/admin/categories');
    }

    private static function postValue(string $key): string
    {
        $raw = filter_input(INPUT_POST, $key, FILTER_UNSAFE_RAW);
        return is_string($raw) ? trim($raw) : '';
    }
}
