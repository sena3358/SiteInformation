<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Accueil', ENT_QUOTES, 'UTF-8') ?></title>
    <style>
        body { font-family: Georgia, "Times New Roman", serif; background: #f8f7f4; color: #1f1f1f; margin: 0; }
        .container { max-width: 980px; margin: 0 auto; padding: 28px 16px 42px; }
        header { border-bottom: 2px solid #1f1f1f; margin-bottom: 20px; padding-bottom: 10px; }
        h1 { margin: 0; font-size: 2rem; }
        .top-links { margin-top: 8px; display: flex; flex-wrap: wrap; gap: 12px; }
        a { color: #0a4a78; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .grid { display: grid; grid-template-columns: 1fr; gap: 14px; }
        article { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 14px; }
        .meta { color: #555; font-size: 0.92rem; margin-bottom: 8px; }
        .image { max-width: 100%; border-radius: 6px; margin-bottom: 10px; }
        .categories { margin: 20px 0; padding: 12px; background: #fff; border: 1px solid #ddd; border-radius: 8px; }
        .categories ul { margin: 0; padding-left: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><?= htmlspecialchars((string) ($title ?? 'Actualites recentes'), ENT_QUOTES, 'UTF-8') ?></h1>
            <?php if (($visitorLoggedIn ?? false) === true): ?>
                <p>Connecte en tant que <strong><?= htmlspecialchars((string) ($visitorName ?? ''), ENT_QUOTES, 'UTF-8') ?></strong></p>
            <?php else: ?>
                <p>Consultez les derniers articles publies.</p>
            <?php endif; ?>
            <nav class="top-links">
                <a href="/login">Connexion visiteur</a>
                <a href="/mon-compte">Mon compte</a>
                <a href="/logout">Deconnexion</a>
                <a href="/admin/login">BackOffice</a>
            </nav>
        </header>

        <section class="categories">
            <h2>Categories</h2>
            <ul>
                <?php foreach (($categories ?? []) as $category): ?>
                    <li>
                        <a href="/categorie/<?= (int) $category['id'] ?>">
                            <?= htmlspecialchars((string) $category['libelle'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <section>
            <h2>Articles recents</h2>
            <div class="grid">
                <?php foreach (($articles ?? []) as $article): ?>
                    <article>
                        <?php if (!empty($article['image'])): ?>
                            <img class="image" src="<?= htmlspecialchars((string) $article['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Illustration de l'article <?= htmlspecialchars((string) $article['titre'], ENT_QUOTES, 'UTF-8') ?>">
                        <?php endif; ?>
                        <h3>
                            <a href="/article/<?= (int) $article['id'] ?>">
                                <?= htmlspecialchars((string) $article['titre'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </h3>
                        <p class="meta">
                            <?= htmlspecialchars((string) ($article['date'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                            - par <?= htmlspecialchars((string) ($article['nom_auteur'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                            <?php if (!empty($article['categorie'])): ?>
                                - <a href="/categorie/<?= (int) ($article['id_categorie'] ?? 0) ?>"><?= htmlspecialchars((string) $article['categorie'], ENT_QUOTES, 'UTF-8') ?></a>
                            <?php endif; ?>
                        </p>
                        <p><?= nl2br(htmlspecialchars(mb_substr((string) ($article['contenu'] ?? ''), 0, 220), ENT_QUOTES, 'UTF-8')) ?>...</p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</body>
</html>
