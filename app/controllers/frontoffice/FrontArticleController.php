<?php

declare(strict_types=1);

require_once __DIR__ . '/../../models/Article.php';
require_once __DIR__ . '/../../models/Category.php';

final class FrontArticleController
{
    public static function show(string $id): void
    {
        if (!ctype_digit($id)) {
            app_halt(404, 'Article introuvable.');
        }

        $articleId = (int) $id;
        $article = Article::findPublishedById($articleId);
        if ($article === null) {
            app_halt(404, 'Article introuvable.');
        }

        Article::incrementViews($articleId);
        $article['vue_count'] = (int) ($article['vue_count'] ?? 0) + 1;

        $articleDate = (string) ($article['date'] ?? '');
        $previousArticle = Article::previousPublished($articleId, $articleDate);
        $nextArticle = Article::nextPublished($articleId, $articleDate);

        require __DIR__ . '/../../views/frontoffice/article/show.php';
    }

    public static function byCategory(string $id): void
    {
        if (!ctype_digit($id)) {
            app_halt(404, 'Categorie introuvable.');
        }

        $categoryId = (int) $id;
        $category = Category::findById($categoryId);
        if ($category === null) {
            app_halt(404, 'Categorie introuvable.');
        }

        $page = filter_input(
            INPUT_GET,
            'page',
            FILTER_VALIDATE_INT,
            ['options' => ['default' => 1, 'min_range' => 1]]
        );
        $currentPage = is_int($page) && $page > 0 ? $page : 1;
        $perPage = 20;

        $totalArticles = Article::countPublishedByCategory($categoryId);
        $totalPages = max(1, (int) ceil($totalArticles / $perPage));
        if ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }

        $offset = ($currentPage - 1) * $perPage;

        $articles = Article::publishedByCategory($categoryId, $perPage, $offset);
        require __DIR__ . '/../../views/frontoffice/article/category.php';
    }
}
