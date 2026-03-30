<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorie - <?= htmlspecialchars((string) $category['libelle'], ENT_QUOTES, 'UTF-8') ?></title>
    <style>
        body { font-family: Georgia, "Times New Roman", serif; background: #f8f7f4; color: #1f1f1f; margin: 0; }
        .container { max-width: 980px; margin: 0 auto; padding: 28px 16px 42px; }
        .list { display: grid; grid-template-columns: 1fr; gap: 14px; }
        article { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 14px; }
        .meta { color: #555; font-size: 0.92rem; margin-bottom: 8px; }
        .image { max-width: 100%; border-radius: 6px; margin-bottom: 10px; }
        a { color: #0a4a78; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <p><a href="/mvc">Retour accueil</a></p>
        <h1>Categorie: <?= htmlspecialchars((string) $category['libelle'], ENT_QUOTES, 'UTF-8') ?></h1>

        <?php if (count($articles) === 0): ?>
            <p>Aucun article publie dans cette categorie pour le moment.</p>
        <?php else: ?>
            <div class="list">
                <?php foreach ($articles as $article): ?>
                    <article>
                        <?php if (!empty($article['image'])): ?>
                            <img class="image" src="<?= htmlspecialchars((string) $article['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Illustration de l'article <?= htmlspecialchars((string) $article['titre'], ENT_QUOTES, 'UTF-8') ?>">
                        <?php endif; ?>
                        <h2><a href="/article/<?= (int) $article['id'] ?>"><?= htmlspecialchars((string) $article['titre'], ENT_QUOTES, 'UTF-8') ?></a></h2>
                        <p class="meta">
                            <?= htmlspecialchars((string) ($article['date'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                            - par <?= htmlspecialchars((string) ($article['nom_auteur'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                            - <?= (int) ($article['vue_count'] ?? 0) ?> vues
                        </p>
                        <p><?= nl2br(htmlspecialchars(mb_substr((string) ($article['contenu'] ?? ''), 0, 220), ENT_QUOTES, 'UTF-8')) ?>...</p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
