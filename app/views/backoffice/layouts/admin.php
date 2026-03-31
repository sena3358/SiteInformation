<?php

declare(strict_types=1);

$flashHtml = '';
if (is_array($flash ?? null) && ($flash['message'] ?? '') !== '') {
    $flashType = ($flash['type'] ?? '') === 'error' ? 'bo-flash-error' : 'bo-flash-success';
    $flashHtml = '<p class="bo-flash ' . $flashType . '">' . ViewService::e((string) $flash['message']) . '</p>';
}

$menu = '';
if (AuthService::isLoggedIn()) {
    $titleLc = strtolower((string) $title);
    $isDashboard = str_contains($titleLc, 'dashboard');
    $isArticles = str_contains($titleLc, 'article');
    $isCategories = str_contains($titleLc, 'categorie');

    $menu = '<nav class="bo-menu" aria-label="Navigation backoffice">'
        . '<a class="' . ($isDashboard ? 'is-active' : '') . '" href="/admin">Dashboard</a>'
        . '<a class="' . ($isArticles ? 'is-active' : '') . '" href="/admin/articles">Articles</a>'
        . '<a class="' . ($isCategories ? 'is-active' : '') . '" href="/admin/categories">Categories</a>'
        . '<a href="/admin/logout">Deconnexion</a>'
        . '</nav>';
}

$userInfo = AuthService::isLoggedIn()
    ? '<p class="bo-user-info">Connecte en tant que: <strong>' . ViewService::e(AuthService::currentAdminName()) . '</strong></p>'
    : '';

$isLoginPage = str_contains(strtolower((string) $title), 'connexion');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ViewService::e($title) ?></title>
    <link rel="stylesheet" href="/assets/css/backoffice.css">
    <!-- TinyMCE local (offline) -->
    <script src="/assets/js/tinymce/tinymce.min.js"></script>
</head>
<body class="<?= $isLoginPage ? 'bo-auth' : '' ?>">
    <div class="bo-shell">
        <?php if (!$isLoginPage): ?>
            <header class="bo-topbar">
                <h1 class="bo-title"><?= ViewService::e($title) ?></h1>
                <?= $userInfo ?>
                <?= $menu ?>
            </header>
        <?php endif; ?>

        <?= $flashHtml ?>

        <?php if ($isLoginPage): ?>
            <?= $content ?>
        <?php else: ?>
            <main class="bo-content">
                <?= $content ?>
            </main>
        <?php endif; ?>
    </div>
</body>
</html>
