<?php

declare(strict_types=1);

require_once __DIR__ . '/../../controllers/frontoffice/HomeController.php';
require_once __DIR__ . '/../../controllers/frontoffice/FrontArticleController.php';
require_once __DIR__ . '/../../controllers/frontoffice/UserController.php';
require_once __DIR__ . '/../../controllers/frontoffice/VisitorAuthController.php';
require_once __DIR__ . '/../../controllers/SitemapController.php';

// SEO
app_add_route($routes, 'GET', '/sitemap.xml', [SitemapController::class, 'xml']);

// Frontend
app_add_route($routes, 'GET', '/home', [HomeController::class, 'index']);
app_add_route($routes, 'GET', '/categorie/@slug', [FrontArticleController::class, 'byCategory']);
app_add_route($routes, 'GET', '/article/@slugParam', [FrontArticleController::class, 'show']);
app_add_route($routes, 'GET', '/users', [UserController::class, 'list']);
app_add_route($routes, 'GET', '/users/form', [UserController::class, 'form']);
app_add_route($routes, 'GET', '/login', [VisitorAuthController::class, 'loginForm']);
app_add_route($routes, 'POST', '/login', [VisitorAuthController::class, 'login']);
app_add_route($routes, 'GET', '/logout', [VisitorAuthController::class, 'logout']);
app_add_route($routes, 'GET', '/mon-compte', [VisitorAuthController::class, 'account']);

// Fallback routes when URL rewriting is unavailable
app_add_route($routes, 'GET', '/home.html', [HomeController::class, 'index']);
app_add_route($routes, 'GET', '/index.html', [HomeController::class, 'index']);
app_add_route($routes, 'GET', '/accueil.html', [HomeController::class, 'index']);
app_add_route($routes, 'GET', '/categorie-@slug.html', [FrontArticleController::class, 'byCategory']);
app_add_route($routes, 'GET', '/article-@slugParam.html', [FrontArticleController::class, 'show']);
app_add_route($routes, 'GET', '/users.html', [UserController::class, 'list']);
app_add_route($routes, 'GET', '/users-form.html', [UserController::class, 'form']);
app_add_route($routes, 'GET', '/login.html', [VisitorAuthController::class, 'loginForm']);
app_add_route($routes, 'POST', '/login.html', [VisitorAuthController::class, 'login']);
app_add_route($routes, 'GET', '/logout.html', [VisitorAuthController::class, 'logout']);
app_add_route($routes, 'GET', '/mon-compte.html', [VisitorAuthController::class, 'account']);
