<?php

declare(strict_types=1);

$flashHtml = '';
if (is_array($flash ?? null) && ($flash['message'] ?? '') !== '') {
    $bg = ($flash['type'] ?? '') === 'error' ? '#ffe3e3' : '#e3f2fd';
    $border = ($flash['type'] ?? '') === 'error' ? '#d32f2f' : '#1565c0';
    $flashHtml = '<p style="background:' . $bg . ';border-left:4px solid ' . $border . ';padding:10px 12px;border-radius:4px;">' . ViewService::e((string) $flash['message']) . '</p>';
}

$menu = '';
if (AuthService::isLoggedIn()) {
    $menu = '<nav style="margin-bottom:16px;display:flex;gap:12px;flex-wrap:wrap;">'
        . '<a href="/admin">Dashboard</a>'
        . '<a href="/admin/articles">Articles</a>'
        . '<a href="/admin/categories">Categories</a>'
        . '<a href="/admin/logout">Deconnexion</a>'
        . '</nav>';
}

$userInfo = AuthService::isLoggedIn()
    ? '<p style="margin-top:0;color:#555;">Connecte en tant que: <strong>' . ViewService::e(AuthService::currentAdminName()) . '</strong></p>'
    : '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ViewService::e($title) ?></title>
    <style>
        body { font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; background: #f7f9fb; margin: 0; padding: 24px; }
        .container { max-width: 980px; margin: 0 auto; background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 2px 18px rgba(0,0,0,.06); }
        a { color: #1565c0; text-decoration: none; }
        a:hover { text-decoration: underline; }
        input, select, textarea { width: 100%; padding: 8px; margin: 4px 0 12px; border: 1px solid #d0d7de; border-radius: 6px; box-sizing: border-box; }
        button { background: #1565c0; color: #fff; border: none; padding: 10px 14px; border-radius: 6px; cursor: pointer; }
        button:hover { background: #0f4fa0; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border-bottom: 1px solid #e6e6e6; padding: 10px; text-align: left; vertical-align: top; }
        .inline { display: inline-block; margin-right: 8px; }
        .danger { background: #b71c1c; }
        .danger:hover { background: #8e1515; }
    </style>
</head>
<body>
    <main class="container">
        <h1 style="margin-top:0;"><?= ViewService::e($title) ?></h1>
        <?= $userInfo ?>
        <?= $menu ?>
        <?= $flashHtml ?>
        <?= $content ?>
    </main>
</body>
</html>
