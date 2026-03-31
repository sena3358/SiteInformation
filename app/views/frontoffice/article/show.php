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
    <link rel="stylesheet" href="/assets/css/frontoffice.css">
</head>
<body>
    <div class="fo-shell">
        <div class="fo-layout">
            <?php 
                $activeNav = 'categories'; 
                $categories = $categoryHighlights ?? [];
                require __DIR__ . '/../partials/sidebar.php'; 
            ?>

            <main class="fo-main">
        <a class="fo-backlink" href="<?= htmlspecialchars(UrlHelper::home(), ENT_QUOTES, 'UTF-8') ?>">Retour accueil</a>
        <article class="fo-article-single">
            <img
                class="fo-article-image"
                src="<?= htmlspecialchars(!empty($article['image']) ? (string) $article['image'] : '/assets/images/618748.jpg', ENT_QUOTES, 'UTF-8') ?>"
                alt="Illustration de l'article <?= htmlspecialchars((string) $article['titre'], ENT_QUOTES, 'UTF-8') ?>"
                loading="lazy"
            >

            <div class="fo-article-single-inner">
                <h1><?= htmlspecialchars((string) $article['titre'], ENT_QUOTES, 'UTF-8') ?></h1>
                <p class="fo-meta">
                Publie le <?= htmlspecialchars((string) ($article['date'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                - par <?= htmlspecialchars((string) ($article['nom_auteur'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                <?php if (!empty($article['categorie'])): ?>
                    - <a href="<?= htmlspecialchars(Category::url(['id' => (int) ($article['id_categorie'] ?? 0), 'libelle' => (string) $article['categorie']]), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) $article['categorie'], ENT_QUOTES, 'UTF-8') ?></a>
                <?php endif; ?>
                - <?= (int) ($article['vue_count'] ?? 0) ?> vues
                </p>

                <div class="fo-content">
                    <?= nl2br(htmlspecialchars((string) ($article['contenu'] ?? ''), ENT_QUOTES, 'UTF-8')) ?>
                </div>

                <nav class="fo-next-prev" aria-label="Navigation entre articles">
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
            </div>
        </article>
            </main>
        </div>
    </div>
</body>
</html>
