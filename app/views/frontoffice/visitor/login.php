<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | <?= htmlspecialchars($siteName ?? 'Actualites', ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="Connectez-vous pour acceder a votre espace personnel sur <?= htmlspecialchars($siteName ?? 'Actualites', ENT_QUOTES, 'UTF-8') ?>.">
    <link rel="stylesheet" href="/assets/css/frontoffice.css">
</head>
<body>
    <div class="fo-shell">
        <div class="fo-layout">
            <?php 
                $activeNav = 'login'; 
                $categories = $categoryHighlights ?? [];
                require __DIR__ . '/../partials/sidebar.php'; 
            ?>

            <main class="fo-main">
        <section class="fo-panel">
            <h1>Connexion visiteur</h1>

            <?php if (is_array($flash ?? null) && ($flash['message'] ?? '') !== ''): ?>
                <p class="fo-flash"><?= htmlspecialchars((string) $flash['message'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>

            <form class="fo-form" method="post" action="<?= htmlspecialchars(UrlHelper::login(), ENT_QUOTES, 'UTF-8') ?>">
                <label for="username">Nom utilisateur</label>
                <input id="username" name="username" required>

                <label for="password">Mot de passe</label>
                <input id="password" name="password" type="password" required>

                <button type="submit">Se connecter</button>
            </form>

            <p><a href="<?= htmlspecialchars(UrlHelper::home(), ENT_QUOTES, 'UTF-8') ?>">Retour accueil</a></p>
        </section>
            </main>
        </div>
    </div>
</body>
</html>
