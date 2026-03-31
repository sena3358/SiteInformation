<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte | <?= htmlspecialchars($siteName ?? 'Actualites', ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="Gerez votre compte visiteur sur <?= htmlspecialchars($siteName ?? 'Actualites', ENT_QUOTES, 'UTF-8') ?>.">
    <link rel="stylesheet" href="/assets/css/frontoffice.css">
</head>
<body>
    <div class="fo-shell">
        <div class="fo-layout">
            <?php $activeNav = 'account'; require __DIR__ . '/../partials/sidebar.php'; ?>

            <main class="fo-main">
        <section class="fo-panel">
            <h1>Mon compte</h1>
            <p>Bienvenue, <strong><?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?></strong>.</p>
            <ul>
                <li><a href="<?= htmlspecialchars(UrlHelper::home(), ENT_QUOTES, 'UTF-8') ?>">Accueil</a></li>
                <li><a href="<?= htmlspecialchars(UrlHelper::logout(), ENT_QUOTES, 'UTF-8') ?>">Se deconnecter</a></li>
            </ul>
        </section>
            </main>
        </div>
    </div>
</body>
</html>
