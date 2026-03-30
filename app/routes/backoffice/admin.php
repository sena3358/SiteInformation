<?php

declare(strict_types=1);

require_once __DIR__ . '/../../controllers/backoffice/HealthController.php';
require_once __DIR__ . '/../../controllers/backoffice/AdminAuthController.php';
require_once __DIR__ . '/../../controllers/backoffice/AdminDashboardController.php';
require_once __DIR__ . '/../../controllers/backoffice/AdminCategoryController.php';
require_once __DIR__ . '/../../controllers/backoffice/AdminArticleController.php';
require_once __DIR__ . '/../../services/common/ResponseService.php';

Flight::route('GET /', static function (): void {
    ResponseService::redirect('/admin');
});

Flight::route('GET /health', [HealthController::class, 'check']);

Flight::route('GET /admin/login', [AdminAuthController::class, 'loginForm']);
Flight::route('POST /admin/login', [AdminAuthController::class, 'login']);
Flight::route('GET /admin/logout', [AdminAuthController::class, 'logout']);

Flight::route('GET /admin', [AdminDashboardController::class, 'index']);

Flight::route('GET /admin/categories', [AdminCategoryController::class, 'index']);
Flight::route('POST /admin/categories/create', [AdminCategoryController::class, 'create']);
Flight::route('POST /admin/categories/update/@id', [AdminCategoryController::class, 'update']);
Flight::route('POST /admin/categories/delete/@id', [AdminCategoryController::class, 'delete']);

Flight::route('GET /admin/articles', [AdminArticleController::class, 'index']);
Flight::route('GET /admin/articles/create', [AdminArticleController::class, 'createForm']);
Flight::route('POST /admin/articles/create', [AdminArticleController::class, 'create']);
Flight::route('GET /admin/articles/edit/@id', [AdminArticleController::class, 'editForm']);
Flight::route('POST /admin/articles/edit/@id', [AdminArticleController::class, 'edit']);
Flight::route('POST /admin/articles/delete/@id', [AdminArticleController::class, 'delete']);
