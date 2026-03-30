<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorie <?= htmlspecialchars((string) $category['libelle'], ENT_QUOTES, 'UTF-8') ?> | <?= htmlspecialchars($siteName ?? 'Actualites', ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="Tous les articles de la categorie <?= htmlspecialchars((string) $category['libelle'], ENT_QUOTES, 'UTF-8') ?> sur <?= htmlspecialchars($siteCountry ?? 'Iran', ENT_QUOTES, 'UTF-8') ?>. <?= (int) ($totalArticles ?? 0) ?> articles disponibles.">
    <link rel="stylesheet" href="/assets/css/frontoffice.css">
</head>
<body>
    <div class="fo-shell">
        <div class="fo-layout">
            <?php $activeNav = 'categories'; require __DIR__ . '/../partials/sidebar.php'; ?>

            <main class="fo-main">
        <a class="fo-backlink" href="/home">Retour accueil</a>
        <h1>Categorie: <?= htmlspecialchars((string) $category['libelle'], ENT_QUOTES, 'UTF-8') ?></h1>
        <p class="fo-page-meta">
            Total: <?= (int) ($totalArticles ?? 0) ?> articles |
            Page <?= (int) ($currentPage ?? 1) ?> / <?= (int) ($totalPages ?? 1) ?>
        </p>

        <?php if (count($articles) === 0): ?>
            <section class="fo-card">
                <p>Aucun article publie dans cette categorie pour le moment.</p>
            </section>
        <?php else: ?>
            <div class="fo-article-grid">
                <?php foreach ($articles as $article): ?>
                    <article class="fo-article">
                        <img
                            class="fo-article-image"
                            src="<?= htmlspecialchars(!empty($article['image']) ? (string) $article['image'] : '/assets/images/wallpaperflare.com_wallpaper%20(9).jpg', ENT_QUOTES, 'UTF-8') ?>"
                            alt="Illustration de l'article <?= htmlspecialchars((string) $article['titre'], ENT_QUOTES, 'UTF-8') ?>"
                            loading="lazy"
                        >
                        <div class="fo-article-body">
                            <h2><a href="<?= htmlspecialchars(Article::url($article), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) $article['titre'], ENT_QUOTES, 'UTF-8') ?></a></h2>
                            <p class="fo-meta">
                                <?= htmlspecialchars((string) ($article['date'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                                - par <?= htmlspecialchars((string) ($article['nom_auteur'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                                - <?= (int) ($article['vue_count'] ?? 0) ?> vues
                            </p>
                            <p class="fo-summary"><?= nl2br(htmlspecialchars(mb_substr((string) ($article['contenu'] ?? ''), 0, 220), ENT_QUOTES, 'UTF-8')) ?>...</p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php if (($totalPages ?? 1) > 1): ?>
                <p class="fo-pagination" aria-label="Pagination categorie">
                    <?php if (($currentPage ?? 1) > 1): ?>
                        <a href="<?= htmlspecialchars(Category::url($category), ENT_QUOTES, 'UTF-8') ?>?page=<?= (int) (($currentPage ?? 1) - 1) ?>">&laquo; Precedent</a>
                    <?php endif; ?>

                    <?php if (($currentPage ?? 1) < ($totalPages ?? 1)): ?>
                        <a href="<?= htmlspecialchars(Category::url($category), ENT_QUOTES, 'UTF-8') ?>?page=<?= (int) (($currentPage ?? 1) + 1) ?>">Suivant &raquo;</a>
                    <?php endif; ?>
                </p>
            <?php endif; ?>
        <?php endif; ?>
            </main>
        </div>
    </div>
</body>
</html>
