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
app_add_route($routes, 'GET', '/', [HomeController::class, 'index']);
app_add_route($routes, 'GET', '/categorie/@id', [FrontArticleController::class, 'byCategory']);
app_add_route($routes, 'GET', '/users', [UserController::class, 'list']);
app_add_route($routes, 'GET', '/users/form', [UserController::class, 'form']);
app_add_route($routes, 'GET', '/login', [VisitorAuthController::class, 'loginForm']);
app_add_route($routes, 'POST', '/login', [VisitorAuthController::class, 'login']);
app_add_route($routes, 'GET', '/logout', [VisitorAuthController::class, 'logout']);
app_add_route($routes, 'GET', '/mon-compte', [VisitorAuthController::class, 'account']);
