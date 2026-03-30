<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | <?= htmlspecialchars($siteName ?? 'Actualites', ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="Connectez-vous pour acceder a votre espace personnel sur <?= htmlspecialchars($siteName ?? 'Actualites', ENT_QUOTES, 'UTF-8') ?>.">
    <style>
        body { font-family: Georgia, "Times New Roman", serif; background: #f8f7f4; color: #1f1f1f; margin: 0; padding: 28px 16px; }
        .container { max-width: 400px; margin: 0 auto; }
        h1 { font-size: 1.8rem; margin-bottom: 20px; }
        form { background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        label { display: block; margin-bottom: 4px; font-weight: bold; }
        input { width: 100%; padding: 8px; margin-bottom: 16px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #0a4a78; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #063a5f; }
        a { color: #0a4a78; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .flash { padding: 10px; margin-bottom: 16px; border-radius: 4px; background: #f0f0f0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Connexion visiteur</h1>

        <?php if (is_array($flash ?? null) && ($flash['message'] ?? '') !== ''): ?>
            <p class="flash"><?= htmlspecialchars((string) $flash['message'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form method="post" action="/login">
            <label for="username">Nom utilisateur</label>
            <input id="username" name="username" required>

            <label for="password">Mot de passe</label>
            <input id="password" name="password" type="password" required>

            <button type="submit">Se connecter</button>
        </form>

        <p style="margin-top: 16px;"><a href="/mvc">Retour accueil</a></p>
    </div>
</body>
</html>
