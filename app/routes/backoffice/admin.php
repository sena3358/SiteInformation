<?php

declare(strict_types=1);

require_once __DIR__ . '/../../controllers/backoffice/HealthController.php';
require_once __DIR__ . '/../../controllers/backoffice/AdminAuthController.php';
require_once __DIR__ . '/../../controllers/backoffice/AdminDashboardController.php';
require_once __DIR__ . '/../../controllers/backoffice/AdminCategoryController.php';
require_once __DIR__ . '/../../controllers/backoffice/AdminArticleController.php';
require_once __DIR__ . '/../../services/common/ResponseService.php';

app_add_route($routes, 'GET', '/', static function (): void {
    ResponseService::redirect('/home');
});

app_add_route($routes, 'GET', '/health', [HealthController::class, 'check']);

app_add_route($routes, 'GET', '/admin/login', [AdminAuthController::class, 'loginForm']);
app_add_route($routes, 'POST', '/admin/login', [AdminAuthController::class, 'login']);
app_add_route($routes, 'GET', '/admin/logout', [AdminAuthController::class, 'logout']);

app_add_route($routes, 'GET', '/admin', [AdminDashboardController::class, 'index']);

app_add_route($routes, 'GET', '/admin/categories', [AdminCategoryController::class, 'index']);
app_add_route($routes, 'POST', '/admin/categories/create', [AdminCategoryController::class, 'create']);
app_add_route($routes, 'POST', '/admin/categories/update/@id', [AdminCategoryController::class, 'update']);
app_add_route($routes, 'POST', '/admin/categories/delete/@id', [AdminCategoryController::class, 'delete']);

app_add_route($routes, 'GET', '/admin/articles', [AdminArticleController::class, 'index']);
app_add_route($routes, 'GET', '/admin/articles/create', [AdminArticleController::class, 'createForm']);
app_add_route($routes, 'POST', '/admin/articles/create', [AdminArticleController::class, 'create']);
app_add_route($routes, 'GET', '/admin/articles/edit/@id', [AdminArticleController::class, 'editForm']);
app_add_route($routes, 'POST', '/admin/articles/edit/@id', [AdminArticleController::class, 'edit']);
app_add_route($routes, 'POST', '/admin/articles/delete/@id', [AdminArticleController::class, 'delete']);

// Fallback routes when URL rewriting is unavailable
app_add_route($routes, 'GET', '/admin-login.html', [AdminAuthController::class, 'loginForm']);
app_add_route($routes, 'POST', '/admin-login.html', [AdminAuthController::class, 'login']);
app_add_route($routes, 'GET', '/admin-deconnexion.html', [AdminAuthController::class, 'logout']);
app_add_route($routes, 'GET', '/admin.html', [AdminDashboardController::class, 'index']);
app_add_route($routes, 'GET', '/admin-articles.html', [AdminArticleController::class, 'index']);
app_add_route($routes, 'GET', '/admin-articles-create.html', [AdminArticleController::class, 'createForm']);
app_add_route($routes, 'POST', '/admin-articles-create.html', [AdminArticleController::class, 'create']);
app_add_route($routes, 'GET', '/admin-articles-edit-@id.html', [AdminArticleController::class, 'editForm']);
app_add_route($routes, 'POST', '/admin-articles-edit-@id.html', [AdminArticleController::class, 'edit']);
app_add_route($routes, 'GET', '/admin-categories.html', [AdminCategoryController::class, 'index']);
