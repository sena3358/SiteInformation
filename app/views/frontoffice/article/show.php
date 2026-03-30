<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $pageTitle = (($article['meta_title'] ?? '') !== '' ? $article['meta_title'] : $article['titre']);
    $metaDesc = ($article['meta_description'] ?? '');
    if ($metaDesc === '') {
        $metaDesc = mb_substr(strip_tags((string) ($article['contenu'] ?? '')), 0, 160) . '...';
    }
    ?>
    <title><?= htmlspecialchars((string) $pageTitle, ENT_QUOTES, 'UTF-8') ?> | <?= htmlspecialchars($siteName ?? 'Actualites', ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="<?= htmlspecialchars((string) $metaDesc, ENT_QUOTES, 'UTF-8') ?>">
    <style>
        body { font-family: Georgia, "Times New Roman", serif; background: #f8f7f4; color: #1f1f1f; margin: 0; }
        .container { max-width: 920px; margin: 0 auto; padding: 28px 16px 42px; }
        article { background: #fff; border: 1px solid #ddd; border-radius: 8px; padding: 20px; }
        .meta { color: #555; margin-bottom: 12px; }
        .hero { width: 100%; border-radius: 6px; margin-bottom: 14px; }
        .content { line-height: 1.6; }
        .nav { display: flex; justify-content: space-between; gap: 16px; margin-top: 20px; }
        a { color: #0a4a78; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <p><a href="/mvc">Retour accueil</a></p>
        <article>
            <h1><?= htmlspecialchars((string) $article['titre'], ENT_QUOTES, 'UTF-8') ?></h1>
            <p class="meta">
                Publie le <?= htmlspecialchars((string) ($article['date'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                - par <?= htmlspecialchars((string) ($article['nom_auteur'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                <?php if (!empty($article['categorie'])): ?>
                    - <a href="/categorie/<?= (int) ($article['id_categorie'] ?? 0) ?>"><?= htmlspecialchars((string) $article['categorie'], ENT_QUOTES, 'UTF-8') ?></a>
                <?php endif; ?>
                - <?= (int) ($article['vue_count'] ?? 0) ?> vues
            </p>

            <?php if (!empty($article['image'])): ?>
                <img class="hero" src="<?= htmlspecialchars((string) $article['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Illustration de l'article <?= htmlspecialchars((string) $article['titre'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy">
            <?php endif; ?>

            <div class="content">
                <?= nl2br(htmlspecialchars((string) ($article['contenu'] ?? ''), ENT_QUOTES, 'UTF-8')) ?>
            </div>

            <nav class="nav">
                <div>
                    <?php if (is_array($previousArticle)): ?>
                        <a href="<?= htmlspecialchars(Article::url($previousArticle), ENT_QUOTES, 'UTF-8') ?>">Article precedent: <?= htmlspecialchars((string) $previousArticle['titre'], ENT_QUOTES, 'UTF-8') ?></a>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if (is_array($nextArticle)): ?>
                        <a href="<?= htmlspecialchars(Article::url($nextArticle), ENT_QUOTES, 'UTF-8') ?>">Article suivant: <?= htmlspecialchars((string) $nextArticle['titre'], ENT_QUOTES, 'UTF-8') ?></a>
                    <?php endif; ?>
                </div>
            </nav>
        </article>
    </div>
</body>
</html>
