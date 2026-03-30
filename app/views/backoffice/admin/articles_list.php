<?php
/** @var list<array<string,mixed>> $articles */
/** @var int $currentPage */
/** @var int $totalPages */
/** @var int $totalArticles */
/** @var int $perPage */

$fallbackImage = '/assets/images/wallpaperflare.com_wallpaper%20(9).jpg';
?>
<section class="bo-stack">
    <div class="bo-actions">
        <a class="bo-btn" href="/admin/articles/create">Ajouter un article</a>
        <p class="bo-muted">
            Total: <?= (int) $totalArticles ?> articles | Page <?= (int) $currentPage ?> / <?= (int) $totalPages ?> | <?= (int) $perPage ?> par page
        </p>
    </div>

    <div class="bo-table-wrap">
        <table class="bo-table">
            <thead>
                <tr>
                    <th>Apercu</th>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Categorie</th>
                    <th>Auteur</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($articles as $article): ?>
                <?php
                $image = trim((string) ($article['image'] ?? ''));
                $imageSrc = $image !== '' ? $image : $fallbackImage;
                $isPublished = ((string) ($article['statut'] ?? '')) === 'publie';
                ?>
                <tr>
                    <td>
                        <img class="bo-thumb" src="<?= ViewService::e($imageSrc) ?>" alt="Apercu article <?= (int) $article['id'] ?>" loading="lazy">
                    </td>
                    <td><?= (int) $article['id'] ?></td>
                    <td><?= ViewService::e((string) $article['titre']) ?></td>
                    <td><?= ViewService::e((string) ($article['categorie'] ?? 'Sans categorie')) ?></td>
                    <td><?= ViewService::e((string) $article['nom_auteur']) ?></td>
                    <td>
                        <span class="bo-badge <?= $isPublished ? 'bo-badge-publie' : 'bo-badge-brouillon' ?>">
                            <?= ViewService::e((string) $article['statut']) ?>
                        </span>
                    </td>
                    <td><?= ViewService::e((string) $article['date']) ?></td>
                    <td>
                        <div class="bo-actions">
                            <a class="bo-btn-ghost" href="/admin/articles/edit/<?= (int) $article['id'] ?>">Editer</a>
                            <form method="post" action="/admin/articles/delete/<?= (int) $article['id'] ?>" onsubmit="return confirm('Supprimer cet article ?')">
                                <button class="bo-btn-danger" type="submit">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1): ?>
        <div class="bo-actions">
            <?php if ($currentPage > 1): ?>
                <a class="bo-btn-ghost" href="/admin/articles?page=<?= (int) ($currentPage - 1) ?>">&laquo; Precedent</a>
            <?php endif; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a class="bo-btn-ghost" href="/admin/articles?page=<?= (int) ($currentPage + 1) ?>">Suivant &raquo;</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</section>
