<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Accueil', ENT_QUOTES, 'UTF-8') ?></title>
    <meta name="description" content="Suivez les dernieres actualites sur la situation en <?= htmlspecialchars($siteCountry ?? 'Iran', ENT_QUOTES, 'UTF-8') ?>. Articles, analyses et informations.">
    <link rel="stylesheet" href="/assets/css/frontoffice.css">
</head>
<body>
    <div class="fo-shell">
        <div class="fo-layout">
            <?php $activeNav = 'home'; require __DIR__ . '/partials/sidebar.php'; ?>

            <main class="fo-main">
        <header>
            <div class="fo-topline">
                <span class="fo-pill">Edition speciale: couverture terrain</span>
                <?php if (($visitorLoggedIn ?? false) === true): ?>
                    <span class="fo-pill">Connecte: <?= htmlspecialchars((string) ($visitorName ?? ''), ENT_QUOTES, 'UTF-8') ?></span>
                <?php endif; ?>
            </div>

            <div class="fo-hero">
                <div class="fo-hero-media" style="background-image:url('/assets/images/618748.jpg');"></div>
                <div class="fo-hero-text">
                    <h1>Actualites - <?= htmlspecialchars($siteCountry ?? 'Iran', ENT_QUOTES, 'UTF-8') ?></h1>
                    <?php if (($visitorLoggedIn ?? false) === true): ?>
                        <p>Suivi personnalise des derniers developpements pour votre veille.</p>
                    <?php else: ?>
                        <p>Consultez les derniers articles publies, analyses et decryptages verifiees.</p>
                    <?php endif; ?>
                </div>
            </div>

            <nav class="fo-nav" aria-label="Navigation principale">
                <a href="/login">Connexion visiteur</a>
                <a href="/mon-compte">Mon compte</a>
                <a href="/logout">Deconnexion</a>
                <a href="/admin/login">BackOffice</a>
            </nav>
        </header>

        <div class="fo-grid">
            <aside class="fo-card">
                <h2>Categories a suivre</h2>
                <ul class="fo-category-briefs">
                    <?php foreach (($categoryHighlights ?? []) as $category): ?>
                        <li>
                            <article class="fo-category-brief">
                                <h3>
                                    <a href="<?= htmlspecialchars(Category::url($category), ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars((string) $category['libelle'], ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                </h3>
                                <p>
                                    <?= (int) ($category['published_count'] ?? 0) ?> article(s) publie(s)
                                    <?php if (!empty($category['last_published_at'])): ?>
                                        - derniere publication: <?= htmlspecialchars((string) $category['last_published_at'], ENT_QUOTES, 'UTF-8') ?>
                                    <?php endif; ?>
                                </p>
                            </article>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </aside>

            <section class="fo-card">
                <h2 class="fo-list-title">Articles recents</h2>
                <div class="fo-article-grid">
                    <?php foreach (($articles ?? []) as $article): ?>
                        <article class="fo-article">
                            <img
                                class="fo-article-image"
                                src="<?= htmlspecialchars(!empty($article['image']) ? (string) $article['image'] : '/assets/images/wallpaperflare.com_wallpaper%20(9).jpg', ENT_QUOTES, 'UTF-8') ?>"
                                alt="Illustration de l'article <?= htmlspecialchars((string) $article['titre'], ENT_QUOTES, 'UTF-8') ?>"
                                loading="lazy"
                            >

                            <div class="fo-article-body">
                                <h3>
                                    <a href="<?= htmlspecialchars(Article::url($article), ENT_QUOTES, 'UTF-8') ?>">
                                        <?= htmlspecialchars((string) $article['titre'], ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                </h3>
                                <p class="fo-meta">
                                    <?= htmlspecialchars((string) ($article['date'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                                    - par <?= htmlspecialchars((string) ($article['nom_auteur'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                                    <?php if (!empty($article['categorie'])): ?>
                                        - <a href="<?= htmlspecialchars(Category::url(['id' => (int) ($article['id_categorie'] ?? 0), 'libelle' => (string) $article['categorie']]), ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars((string) $article['categorie'], ENT_QUOTES, 'UTF-8') ?></a>
                                    <?php endif; ?>
                                </p>
                                <p class="fo-summary"><?= nl2br(htmlspecialchars(mb_substr((string) ($article['contenu'] ?? ''), 0, 220), ENT_QUOTES, 'UTF-8')) ?>...</p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
            </main>
        </div>
    </div>
</body>
</html>
