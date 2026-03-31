<?php /** @var list<array{id:int,libelle:string}> $categories */ ?>
<?php
$categoryImages = [
    '/assets/images/618748.jpg',
    '/assets/images/wallpaperflare.com_wallpaper%20(9).jpg',
];
?>

<section class="bo-stack">
    <article class="bo-card">
        <h2 class="bo-section-title">Nouvelle categorie</h2>
        <p class="bo-muted">Creez des categories claires pour structurer les publications.</p>
        <form class="bo-form-grid" method="post" action="<?= htmlspecialchars(UrlHelper::adminCategoriesCreate(), ENT_QUOTES, 'UTF-8') ?>">
            <div class="bo-field">
                <label for="libelle">Libelle</label>
                <input class="bo-input" id="libelle" name="libelle" maxlength="120" required>
            </div>
            <div class="bo-actions">
                <button class="bo-btn" type="submit">Ajouter</button>
            </div>
        </form>
    </article>

    <article class="bo-stack">
        <h2 class="bo-section-title">Liste des categories</h2>
        <div class="bo-table-wrap">
            <table class="bo-table">
                <thead>
                    <tr>
                        <!-- <th>Apercu</th> -->
                        <th>ID</th>
                        <th>Libelle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $category): ?>
                    <?php $previewImage = $categoryImages[((int) $category['id']) % count($categoryImages)]; ?>
                    <tr>
                        <!-- <td>
                            <img class="bo-thumb" src="<?= ViewService::e($previewImage) ?>" alt="Apercu categorie <?= (int) $category['id'] ?>" loading="lazy">
                        </td> -->
                        <td><?= (int) $category['id'] ?></td>
                        <td>
                            <form class="bo-actions" method="post" action="<?= htmlspecialchars(UrlHelper::adminCategoriesUpdate((int) $category['id']), ENT_QUOTES, 'UTF-8') ?>">
                                <input class="bo-input" style="min-width:220px;" name="libelle" value="<?= ViewService::e((string) $category['libelle']) ?>" required>
                                <button class="bo-btn-ghost" type="submit">Modifier</button>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="<?= htmlspecialchars(UrlHelper::adminCategoriesDelete((int) $category['id']), ENT_QUOTES, 'UTF-8') ?>" onsubmit="return confirm('Supprimer cette categorie ?')">
                                <button class="bo-btn-danger" type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </article>
</section>
