<?php

declare(strict_types=1);

require_once __DIR__ . '/../../models/Article.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../services/backoffice/AuthService.php';
require_once __DIR__ . '/../../services/backoffice/ViewService.php';

final class AdminDashboardController
{
    public static function index(): void
    {
        AuthService::requireAdmin();

        ViewService::render('BackOffice - Tableau de bord', 'admin/dashboard', [
            'articleCount' => Article::countAll(),
            'publishedCount' => Article::countPublished(),
            'categoryCount' => Category::countAll(),
        ]);
    }
}
