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

        $page = filter_input(
            INPUT_GET,
            'page',
            FILTER_VALIDATE_INT,
            ['options' => ['default' => 1, 'min_range' => 1]]
        );
        $currentPage = is_int($page) && $page > 0 ? $page : 1;
        $perPage = 100;

        $totalArticles = Article::countAll();
        $totalPages = max(1, (int) ceil($totalArticles / $perPage));
        if ($currentPage > $totalPages) {
            $currentPage = $totalPages;
        }

        $offset = ($currentPage - 1) * $perPage;

        ViewService::render('BackOffice - Articles', 'admin/articles_list', [
            'articles' => Article::allWithCategory($perPage, $offset),
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'totalArticles' => $totalArticles,
            'perPage' => $perPage,
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

        $errorMessage = '';
        $payload = self::payloadFromRequest(null, $errorMessage);
        if ($payload === null) {
            AuthService::setFlash('error', $errorMessage !== '' ? $errorMessage : 'Titre, contenu et auteur sont obligatoires.');
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

        $articleId = (int) $id;
        $existingArticle = Article::findById($articleId);
        if ($existingArticle === null) {
            AuthService::setFlash('error', 'Article introuvable.');
            ResponseService::redirect('/admin/articles');
        }

        $errorMessage = '';
        $payload = self::payloadFromRequest((string) ($existingArticle['image'] ?? ''), $errorMessage);
        if ($payload === null) {
            AuthService::setFlash('error', $errorMessage !== '' ? $errorMessage : 'Titre, contenu et auteur sont obligatoires.');
            ResponseService::redirect('/admin/articles/edit/' . $articleId);
        }

        Article::update($articleId, $payload);
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
    private static function payloadFromRequest(?string $existingImagePath = null, string &$errorMessage = ''): ?array
    {
        $titre = self::postValue('titre');
        $contenu = self::postValue('contenu');
        $nomAuteur = self::postValue('nom_auteur');

        if ($titre === '' || $contenu === '' || $nomAuteur === '') {
            $errorMessage = 'Titre, contenu et auteur sont obligatoires.';
            return null;
        }

        $image = self::resolveImagePathFromRequest($existingImagePath, $errorMessage);
        if ($errorMessage !== '') {
            return null;
        }

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

    private static function resolveImagePathFromRequest(?string $existingImagePath, string &$errorMessage): string
    {
        $errorMessage = '';

        $file = $_FILES['image_file'] ?? null;
        if (is_array($file)) {
            $uploadError = (int) ($file['error'] ?? UPLOAD_ERR_NO_FILE);
            if ($uploadError === UPLOAD_ERR_OK) {
                $tmpName = (string) ($file['tmp_name'] ?? '');
                $size = (int) ($file['size'] ?? 0);

                if ($tmpName === '' || !is_uploaded_file($tmpName)) {
                    $errorMessage = 'Upload image invalide.';
                    return '';
                }

                if ($size > 5 * 1024 * 1024) {
                    $errorMessage = 'Image trop volumineuse (max 5 Mo).';
                    return '';
                }

                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = (string) $finfo->file($tmpName);
                $allowed = [
                    'image/jpeg' => 'jpg',
                    'image/png' => 'png',
                    'image/webp' => 'webp',
                    'image/gif' => 'gif',
                ];

                if (!isset($allowed[$mime])) {
                    $errorMessage = 'Format image non supporte. Utilisez JPG, PNG, WEBP ou GIF.';
                    return '';
                }

                $uploadDir = __DIR__ . '/../../../public/assets/images/uploads';
                if (!is_dir($uploadDir) && !mkdir($uploadDir, 0775, true) && !is_dir($uploadDir)) {
                    $errorMessage = 'Impossible de creer le dossier de destination des images.';
                    return '';
                }

                try {
                    $filename = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
                } catch (Exception $exception) {
                    $filename = uniqid('img_', true) . '.' . $allowed[$mime];
                }

                $targetPath = $uploadDir . DIRECTORY_SEPARATOR . $filename;
                if (!move_uploaded_file($tmpName, $targetPath)) {
                    $errorMessage = 'Echec lors de la sauvegarde de l\'image.';
                    return '';
                }

                return '/assets/images/uploads/' . $filename;
            }

            if ($uploadError !== UPLOAD_ERR_NO_FILE) {
                $errorMessage = 'Erreur lors de l\'upload de l\'image.';
                return '';
            }
        }

        $libraryImage = self::postValue('image_library');
        if ($libraryImage !== '') {
            if (str_starts_with($libraryImage, '/assets/images/') && !str_contains($libraryImage, '..')) {
                return $libraryImage;
            }

            $errorMessage = 'Chemin d\'image de bibliotheque invalide.';
            return '';
        }

        if ($existingImagePath !== null && $existingImagePath !== '') {
            return $existingImagePath;
        }

        return '';
    }

    private static function postValue(string $key): string
    {
        $raw = filter_input(INPUT_POST, $key, FILTER_UNSAFE_RAW);
        return is_string($raw) ? trim($raw) : '';
    }
}
