<?php

declare(strict_types=1);

require_once __DIR__ . '/../../models/Article.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../services/backoffice/AuthService.php';
require_once __DIR__ . '/../../services/common/ResponseService.php';
require_once __DIR__ . '/../../services/backoffice/ViewService.php';

final class AdminArticleController
{
    public static function index(): void
    {
        AuthService::requireAdmin();
        ViewService::render('BackOffice - Articles', 'admin/articles_list', [
            'articles' => Article::allWithCategory(),
        ]);
    }

    public static function createForm(): void
    {
        AuthService::requireAdmin();
        ViewService::render('BackOffice - Ajouter un article', 'admin/articles_form', [
            'categories' => Category::all(),
            'article' => null,
            'action' => '/admin/articles/create',
        ]);
    }

    public static function create(): void
    {
        AuthService::requireAdmin();

        $payload = self::payloadFromRequest();
        if ($payload === null) {
            AuthService::setFlash('error', 'Titre, contenu et auteur sont obligatoires.');
            ResponseService::redirect('/admin/articles/create');
        }

        Article::create($payload);
        AuthService::setFlash('success', 'Article cree.');
        ResponseService::redirect('/admin/articles');
    }

    public static function editForm(string $id): void
    {
        AuthService::requireAdmin();

        $article = Article::findById((int) $id);
        if ($article === null) {
            AuthService::setFlash('error', 'Article introuvable.');
            ResponseService::redirect('/admin/articles');
        }

        ViewService::render('BackOffice - Editer article #' . (int) $id, 'admin/articles_form', [
            'categories' => Category::all(),
            'article' => $article,
            'action' => '/admin/articles/edit/' . (int) $id,
        ]);
    }

    public static function edit(string $id): void
    {
        AuthService::requireAdmin();

        $payload = self::payloadFromRequest();
        if ($payload === null) {
            AuthService::setFlash('error', 'Titre, contenu et auteur sont obligatoires.');
            ResponseService::redirect('/admin/articles/edit/' . (int) $id);
        }

        Article::update((int) $id, $payload);
        AuthService::setFlash('success', 'Article modifie.');
        ResponseService::redirect('/admin/articles');
    }

    public static function delete(string $id): void
    {
        AuthService::requireAdmin();
        Article::delete((int) $id);
        AuthService::setFlash('success', 'Article supprime.');
        ResponseService::redirect('/admin/articles');
    }

    /** @return array<string,mixed>|null */
    private static function payloadFromRequest(): ?array
    {
        $titre = self::postValue('titre');
        $contenu = self::postValue('contenu');
        $nomAuteur = self::postValue('nom_auteur');

        if ($titre === '' || $contenu === '' || $nomAuteur === '') {
            return null;
        }

        $image = self::postValue('image');
        $statut = self::postValue('statut') === 'publie' ? 'publie' : 'brouillon';
        $metaTitle = self::postValue('meta_title');
        $metaDescription = self::postValue('meta_description');
        $idCategorieRaw = self::postValue('id_categorie');
        $idCategorie = ctype_digit($idCategorieRaw) ? (int) $idCategorieRaw : null;

        return [
            'id_categorie' => $idCategorie,
            'titre' => $titre,
            'contenu' => $contenu,
            'image' => $image !== '' ? $image : null,
            'nom_auteur' => $nomAuteur,
            'statut' => $statut,
            'meta_title' => $metaTitle !== '' ? $metaTitle : null,
            'meta_description' => $metaDescription !== '' ? $metaDescription : null,
        ];
    }

    private static function postValue(string $key): string
    {
        $raw = filter_input(INPUT_POST, $key, FILTER_UNSAFE_RAW);
        return is_string($raw) ? trim($raw) : '';
    }
}
