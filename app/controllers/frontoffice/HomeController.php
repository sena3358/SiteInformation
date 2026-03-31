<?php

declare(strict_types=1);

require_once __DIR__ . '/../../models/Article.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../models/Setting.php';
require_once __DIR__ . '/../../services/frontoffice/VisitorAuthService.php';

final class HomeController
{
    public static function index(): void
    {
        $siteName = Setting::getSiteName();
        $siteCountry = Setting::getCountry();
        $title = 'Actualites recentes | ' . $siteName;
        $topViewedArticles = Article::topViewed(3);
        $articles = Article::recentPublished(10);
        $categoryHighlights = Category::allWithPublishedStats();
        $visitorLoggedIn = VisitorAuthService::isLoggedIn();
        $visitorName = VisitorAuthService::currentName();
        require __DIR__ . '/../../views/frontoffice/home.php';
    }
}
