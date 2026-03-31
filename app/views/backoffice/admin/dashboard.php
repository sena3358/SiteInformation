<section class="bo-stack">
    <div class="bo-hero-grid">
        <article class="bo-hero-tile">
            <h2>Centre de commande editorial</h2>
            <p>Suivez en temps reel l'etat des publications et accedez rapidement aux operations courantes.</p>
        </article>
        <article class="bo-hero-tile">
            <h2>Priorites du jour</h2>
            <p>Verifiez les brouillons a finaliser, les categories a mettre a jour et les publications recentes.</p>
        </article>
    </div>

    <div class="bo-grid-3" aria-label="Statistiques principales">
        <article class="bo-card">
            <p class="bo-card-title">Articles</p>
            <p class="bo-card-value"><?= (int) $articleCount ?></p>
        </article>
        <article class="bo-card">
            <p class="bo-card-title">Articles publies</p>
            <p class="bo-card-value"><?= (int) $publishedCount ?></p>
        </article>
        <article class="bo-card">
            <p class="bo-card-title">Categories</p>
            <p class="bo-card-value"><?= (int) $categoryCount ?></p>
        </article>
    </div>

    <div class="bo-actions">
        <a class="bo-btn" href="<?= htmlspecialchars(UrlHelper::adminArticlesCreate(), ENT_QUOTES, 'UTF-8') ?>">Creer un article</a>
        <a class="bo-btn-ghost" href="<?= htmlspecialchars(UrlHelper::adminCategories(), ENT_QUOTES, 'UTF-8') ?>">Gerer les categories</a>
        <a class="bo-btn-ghost" href="<?= htmlspecialchars(UrlHelper::adminArticles(), ENT_QUOTES, 'UTF-8') ?>">Voir les articles</a>
    </div>
</section>
