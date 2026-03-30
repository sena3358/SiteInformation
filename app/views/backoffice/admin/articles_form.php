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
?>
<form method="post" action="<?= ViewService::e($action) ?>">
    <label for="titre">Titre</label>
    <input id="titre" name="titre" maxlength="255" value="<?= ViewService::e($articleTitre) ?>" required>

    <label for="id_categorie">Categorie</label>
    <select id="id_categorie" name="id_categorie">
        <option value="">Sans categorie</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= (int) $category['id'] ?>"<?= $articleIdCategorie === (int) $category['id'] ? ' selected' : '' ?>>
                <?= ViewService::e((string) $category['libelle']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="nom_auteur">Auteur</label>
    <input id="nom_auteur" name="nom_auteur" maxlength="120" value="<?= ViewService::e($articleAuteur) ?>" required>

    <label for="image">Image (URL ou chemin)</label>
    <input id="image" name="image" maxlength="255" value="<?= ViewService::e($articleImage) ?>">

    <label for="statut">Statut</label>
    <select id="statut" name="statut">
        <option value="brouillon"<?= $articleStatut === 'publie' ? '' : ' selected' ?>>Brouillon</option>
        <option value="publie"<?= $articleStatut === 'publie' ? ' selected' : '' ?>>Publie</option>
    </select>

    <label for="meta_title">Meta title</label>
    <input id="meta_title" name="meta_title" maxlength="255" value="<?= ViewService::e($articleMetaTitle) ?>">

    <label for="meta_description">Meta description</label>
    <textarea id="meta_description" name="meta_description" rows="3"><?= ViewService::e($articleMetaDescription) ?></textarea>

    <label for="contenu">Contenu</label>
    <textarea id="contenu" name="contenu" rows="10" required><?= ViewService::e($articleContenu) ?></textarea>

    <button type="submit"><?= is_array($article) ? 'Enregistrer' : 'Creer l\'article' ?></button>
</form>
