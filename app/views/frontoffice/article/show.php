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
                <article class="fo-article-detail">
                    <!-- Header with breadcrumb/categories -->
                    <header class="fo-article-header">
                        <?php if (!empty($article['categorie'])): ?>
                            <div class="fo-article-breadcrumb">
                                <a href="<?= htmlspecialchars(Category::url(['id' => (int) ($article['id_categorie'] ?? 0), 'libelle' => (string) $article['categorie']]), ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars((string) $article['categorie'], ENT_QUOTES, 'UTF-8') ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <h1 class="fo-article-title"><?= htmlspecialchars((string) $article['titre'], ENT_QUOTES, 'UTF-8') ?></h1>
                        
                        <p class="fo-article-description"><?= htmlspecialchars((string) $metaDesc, ENT_QUOTES, 'UTF-8') ?></p>
                        
                        <div class="fo-article-meta-section">
                            <div class="fo-article-meta">
                                <span class="fo-article-author">Par <?= htmlspecialchars((string) ($article['nom_auteur'] ?? ''), ENT_QUOTES, 'UTF-8') ?></span>
                                <span class="fo-article-date">Publié aujourd'hui à 10h24</span>
                                <span class="fo-article-reading-time">Lecture 4 min.</span>
                            </div>
                            
                            <div class="fo-article-actions">
                                <!-- <button class="fo-article-action-btn" title="Lire plus tard">► Lire plus tard</button>
                                <button class="fo-article-action-btn" title="Partager">↗ Partager</button> -->
                            </div>
                        </div>

                        <!-- <div class="fo-article-badge">🔒 Article réservé aux abonnés</div> -->
                    </header>

                    <!-- Main content with sidebar -->
                    <div class="fo-article-layout">
                        <!-- Main content -->
                        <div class="fo-article-content">
                            <figure class="fo-article-main-image">
                                <img
                                    src="<?= htmlspecialchars(!empty($article['image']) ? (string) $article['image'] : '/assets/images/618748.jpg', ENT_QUOTES, 'UTF-8') ?>"
                                    alt="<?= htmlspecialchars((string) $article['titre'], ENT_QUOTES, 'UTF-8') ?>"
                                    loading="lazy"
                                >
                                <figcaption class="fo-article-caption">
                                    <?= htmlspecialchars((string) $article['titre'], ENT_QUOTES, 'UTF-8') ?>
                                </figcaption>
                            </figure>

                            <div class="fo-article-body">
                                <?= nl2br(htmlspecialchars((string) ($article['contenu'] ?? ''), ENT_QUOTES, 'UTF-8')) ?>
                            </div>

                            <!-- Navigation -->
                            <nav class="fo-article-nav" aria-label="Navigation entre articles">
                                <?php if (is_array($previousArticle)): ?>
                                    <a class="fo-article-nav-prev" href="<?= htmlspecialchars(Article::url($previousArticle), ENT_QUOTES, 'UTF-8') ?>">
                                        ← <?= htmlspecialchars((string) $previousArticle['titre'], ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                <?php endif; ?>
                                <?php if (is_array($nextArticle)): ?>
                                    <a class="fo-article-nav-next" href="<?= htmlspecialchars(Article::url($nextArticle), ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars((string) $nextArticle['titre'], ENT_QUOTES, 'UTF-8') ?> →
                                    </a>
                                <?php endif; ?>
                            </nav>
                        </div>

                        <!-- Sidebar -->
                        <!-- <aside class="fo-article-sidebar">
                            <div class="fo-article-sponsored">
                                <h3 class="fo-article-sponsored-title">Sponsored stories</h3>
                                <a href="#" class="fo-article-sponsored-item">
                                    <img src="/assets/images/wallpaperflare.com_wallpaper%20(9).jpg" alt="Sponsored">
                                    <span>Ce dispositif change la vie des seniors qui l'entendent...</span>
                                    <small>Sense</small>
                                </a>
                            </div>
                        </aside> -->
                    </div>
                </article>
            </main>
        </div>
    </div>
</body>
</html>
