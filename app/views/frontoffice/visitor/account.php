<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte | <?= htmlspecialchars($siteName ?? 'Actualites', ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="Gerez votre compte visiteur sur <?= htmlspecialchars($siteName ?? 'Actualites', ENT_QUOTES, 'UTF-8') ?>.">
    <style>
        body { font-family: Georgia, "Times New Roman", serif; background: #f8f7f4; color: #1f1f1f; margin: 0; padding: 28px 16px; }
        .container { max-width: 600px; margin: 0 auto; }
        h1 { font-size: 1.8rem; margin-bottom: 20px; }
        .card { background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        ul { list-style: none; padding: 0; margin-top: 20px; }
        li { margin-bottom: 10px; }
        a { color: #0a4a78; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mon compte</h1>
        <div class="card">
            <p>Bienvenue, <strong><?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?></strong>.</p>

            <ul>
                <li><a href="/mvc">Accueil</a></li>
                <li><a href="/logout">Se deconnecter</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
