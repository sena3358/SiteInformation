<?php

declare(strict_types=1);

require_once __DIR__ . '/../../models/Article.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../services/frontoffice/VisitorAuthService.php';

final class HomeController
{
    public static function index(): void
    {
        $title = 'Actualites recentes';
        $articles = Article::recentPublished(10);
        $categories = Category::all();
        $visitorLoggedIn = VisitorAuthService::isLoggedIn();
        $visitorName = VisitorAuthService::currentName();
        require __DIR__ . '/../../views/frontoffice/home.php';
    }
}
