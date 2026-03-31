<?php
/** @var list<array{id:int,libelle:string}> $categories */
/** @var array<string,mixed>|null $article */
/** @var string $action */

$articleIdCategorie = is_array($article) && isset($article['id_categorie']) ? (int) $article['id_categorie'] : 0;
$articleTitre = is_array($article) ? (string) ($article['titre'] ?? '') : '';
$articleAuteur = is_array($article) ? (string) ($article['nom_auteur'] ?? '') : '';
$articleImage = is_array($article) ? (string) ($article['image'] ?? '') : '';
$articleStatut = is_array($article) ? (string) ($article['statut'] ?? 'brouillon') : 'brouillon';
$articleMetaTitle = is_array($article) ? (string) ($article['meta_title'] ?? '') : '';
$articleMetaDescription = is_array($article) ? (string) ($article['meta_description'] ?? '') : '';
$articleContenu = is_array($article) ? (string) ($article['contenu'] ?? '') : '';
$frontofficeImages = [
    '618748.jpg',
    'wallpaperflare.com_wallpaper (9).jpg',
];
?>
<section class="bo-stack">
    <h2 class="bo-section-title"><?= is_array($article) ? 'Modifier un article' : 'Nouvel article' ?></h2>
    <p class="bo-muted">Utilisez les champs SEO et choisissez une image issue du meme repertoire visuel que le frontoffice.</p>

    <form class="bo-form-grid" method="post" action="<?= ViewService::e($action) ?>">
        <div class="bo-field">
            <label for="titre">Titre</label>
            <input class="bo-input" id="titre" name="titre" maxlength="255" value="<?= ViewService::e($articleTitre) ?>" required>
        </div>

        <div class="bo-form-2col">
            <div class="bo-field">
                <label for="id_categorie">Categorie</label>
                <select class="bo-select" id="id_categorie" name="id_categorie">
                    <option value="">Sans categorie</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= (int) $category['id'] ?>"<?= $articleIdCategorie === (int) $category['id'] ? ' selected' : '' ?>>
                            <?= ViewService::e((string) $category['libelle']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="bo-field">
                <label for="nom_auteur">Auteur</label>
                <input class="bo-input" id="nom_auteur" name="nom_auteur" maxlength="120" value="<?= ViewService::e($articleAuteur) ?>" required>
            </div>
        </div>

        <div class="bo-form-2col">
            <div class="bo-field">
                <label for="statut">Statut</label>
                <select class="bo-select" id="statut" name="statut">
                    <option value="brouillon"<?= $articleStatut === 'publie' ? '' : ' selected' ?>>Brouillon</option>
                    <option value="publie"<?= $articleStatut === 'publie' ? ' selected' : '' ?>>Publie</option>
                </select>
            </div>

            <div class="bo-field">
                <label for="image">Image (URL ou chemin)</label>
                <input class="bo-input" id="image" name="image" maxlength="255" value="<?= ViewService::e($articleImage) ?>" placeholder="/assets/images/618748.jpg">
            </div>
        </div>

        <div class="bo-field">
            <label for="meta_title">Meta title</label>
            <input class="bo-input" id="meta_title" name="meta_title" maxlength="255" value="<?= ViewService::e($articleMetaTitle) ?>">
        </div>

        <div class="bo-field">
            <label for="meta_description">Meta description</label>
            <textarea class="bo-textarea" id="meta_description" name="meta_description" rows="3"><?= ViewService::e($articleMetaDescription) ?></textarea>
        </div>

        <div class="bo-field">
            <label for="contenu">Contenu</label>
            <textarea class="bo-textarea" id="contenu" name="contenu" rows="12" required><?= ViewService::e($articleContenu) ?></textarea>
        </div>

        <section class="bo-stack" aria-label="Bibliotheque d'images frontoffice">
            <h3 class="bo-section-title">Bibliotheque d'images coherente frontoffice</h3>
            <div class="bo-image-library">
                <?php foreach ($frontofficeImages as $filename): ?>
                    <?php $imagePath = '/assets/images/' . rawurlencode($filename); ?>
                    <article class="bo-image-choice">
                        <img src="<?= ViewService::e($imagePath) ?>" alt="Image <?= ViewService::e($filename) ?>" loading="lazy">
                        <button class="bo-btn-ghost" type="button" data-image-path="<?= ViewService::e($imagePath) ?>">Utiliser</button>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <div class="bo-actions">
            <button class="bo-btn" type="submit"><?= is_array($article) ? 'Enregistrer' : 'Creer l\'article' ?></button>
            <a class="bo-btn-ghost" href="<?= htmlspecialchars(UrlHelper::adminArticles(), ENT_QUOTES, 'UTF-8') ?>">Retour a la liste</a>
        </div>
    </form>
</section>

<script>
    // Initialize TinyMCE on content field
    tinymce.init({
        selector: '#contenu',
        plugins: 'lists link image code table wordcount',
        toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image | code',
        menubar: 'file edit view insert format tools',
        height: 400,
        branding: false,
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto; }',
        link_default_target: '_blank',
    });

    // Image library button functionality
    document.querySelectorAll('[data-image-path]').forEach(function (button) {
        button.addEventListener('click', function () {
            var imageInput = document.getElementById('image');
            if (imageInput) {
                imageInput.value = button.getAttribute('data-image-path') || '';
                imageInput.focus();
            }
        });
    });
</script>
