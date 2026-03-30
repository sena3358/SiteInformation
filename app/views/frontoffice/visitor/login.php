<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion visiteur</title>
</head>
<body>
    <h1>Connexion visiteur</h1>

    <?php if (is_array($flash ?? null) && ($flash['message'] ?? '') !== ''): ?>
        <p><?= htmlspecialchars((string) $flash['message'], ENT_QUOTES, 'UTF-8') ?></p>
    <?php endif; ?>

    <form method="post" action="/login" style="max-width:380px;">
        <label for="username">Nom utilisateur</label>
        <input id="username" name="username" required>

        <label for="password">Mot de passe</label>
        <input id="password" name="password" type="password" required>

        <button type="submit">Se connecter</button>
    </form>

    <p><a href="/mvc">Retour accueil</a></p>
</body>
</html>
