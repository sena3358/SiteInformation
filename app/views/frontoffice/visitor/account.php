<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte visiteur</title>
</head>
<body>
    <h1>Mon compte</h1>
    <p>Bienvenue, <strong><?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?></strong>.</p>

    <ul>
        <li><a href="/mvc">Accueil</a></li>
        <li><a href="/logout">Se deconnecter</a></li>
    </ul>
</body>
</html>
