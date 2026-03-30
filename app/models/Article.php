<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/bootstrap.php';

final class Article
{
    /** @param array<string,mixed> $article */
    public static function url(array $article): string
    {
        $id = (int) ($article['id'] ?? 0);
        $slug = !empty($article['slug']) ? $article['slug'] : slugify((string) ($article['titre'] ?? ''));
        return '/article/' . $id . '-' . $slug;
    }

    public static function countAll(): int
    {
        return (int) db()->query('SELECT COUNT(*) FROM articles')->fetchColumn();
    }

    public static function countPublished(): int
    {
        return (int) db()->query("SELECT COUNT(*) FROM articles WHERE statut = 'publie'")->fetchColumn();
    }

    /** @return list<array<string,mixed>> */
    public static function allWithCategory(int $limit = 100, int $offset = 0): array
    {
        $sql = 'SELECT a.id, a.id_categorie, a.titre, a.slug, a.contenu, a.image, a.date, a.nom_auteur, a.statut, a.meta_title, a.meta_description, c.libelle AS categorie
                FROM articles a
                LEFT JOIN categories c ON c.id = a.id_categorie
                ORDER BY a.date DESC, a.id DESC
                LIMIT :limite OFFSET :decalage';

        $stmt = db()->prepare($sql);
        $stmt->bindValue(':limite', max(1, $limit), PDO::PARAM_INT);
        $stmt->bindValue(':decalage', max(0, $offset), PDO::PARAM_INT);
        $stmt->execute();
        /** @var list<array<string,mixed>> $rows */
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    /** @return array<string,mixed>|null */
    public static function findById(int $id): ?array
    {
        $stmt = db()->prepare('SELECT * FROM articles WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        return is_array($article) ? $article : null;
    }

    /** @return list<array<string,mixed>> */
    public static function recentPublished(int $limit = 10): array
    {
        $sql = 'SELECT a.id, a.id_categorie, a.titre, a.slug, a.contenu, a.image, a.date, a.nom_auteur, a.statut, a.vue_count, a.meta_title, a.meta_description, c.libelle AS categorie
                FROM articles a
                LEFT JOIN categories c ON c.id = a.id_categorie
                WHERE a.statut = :statut
                ORDER BY a.date DESC, a.id DESC
                LIMIT :limite';

        $stmt = db()->prepare($sql);
        $stmt->bindValue(':statut', 'publie');
        $stmt->bindValue(':limite', max(1, $limit), PDO::PARAM_INT);
        $stmt->execute();

        /** @var list<array<string,mixed>> $rows */
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    /** @return array<string,mixed>|null */
    public static function findPublishedById(int $id): ?array
    {
        $sql = 'SELECT a.id, a.id_categorie, a.titre, a.slug, a.contenu, a.image, a.date, a.nom_auteur, a.statut, a.vue_count, a.meta_title, a.meta_description, c.libelle AS categorie
                FROM articles a
                LEFT JOIN categories c ON c.id = a.id_categorie
                WHERE a.id = :id AND a.statut = :statut
                LIMIT 1';

        $stmt = db()->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'statut' => 'publie',
        ]);

        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        return is_array($article) ? $article : null;
    }

    public static function incrementViews(int $id): void
    {
        $stmt = db()->prepare('UPDATE articles SET vue_count = vue_count + 1 WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public static function countPublishedByCategory(int $categoryId): int
    {
        $sql = 'SELECT COUNT(*)
                FROM articles
                WHERE statut = :statut AND id_categorie = :id_categorie';

        $stmt = db()->prepare($sql);
        $stmt->execute([
            'statut' => 'publie',
            'id_categorie' => $categoryId,
        ]);

        return (int) $stmt->fetchColumn();
    }

    /** @return list<array<string,mixed>> */
    public static function publishedByCategory(int $categoryId, int $limit = 20, int $offset = 0): array
    {
        $sql = 'SELECT a.id, a.id_categorie, a.titre, a.slug, a.contenu, a.image, a.date, a.nom_auteur, a.statut, a.vue_count, a.meta_title, a.meta_description, c.libelle AS categorie
                FROM articles a
                LEFT JOIN categories c ON c.id = a.id_categorie
                WHERE a.statut = :statut AND a.id_categorie = :id_categorie
                ORDER BY a.date DESC, a.id DESC
                LIMIT :limite OFFSET :decalage';

        $stmt = db()->prepare($sql);
        $stmt->bindValue(':statut', 'publie');
        $stmt->bindValue(':id_categorie', $categoryId, PDO::PARAM_INT);
        $stmt->bindValue(':limite', max(1, $limit), PDO::PARAM_INT);
        $stmt->bindValue(':decalage', max(0, $offset), PDO::PARAM_INT);
        $stmt->execute();

        /** @var list<array<string,mixed>> $rows */
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    /** @return array<string,mixed>|null */
    public static function previousPublished(int $currentId, string $currentDate): ?array
    {
        $sql = 'SELECT id, titre, slug
                FROM articles
                WHERE statut = :statut
                  AND (date < :date OR (date = :date AND id < :id))
                ORDER BY date DESC, id DESC
                LIMIT 1';

        $stmt = db()->prepare($sql);
        $stmt->execute([
            'statut' => 'publie',
            'date' => $currentDate,
            'id' => $currentId,
        ]);

        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        return is_array($article) ? $article : null;
    }

    /** @return array<string,mixed>|null */
    public static function nextPublished(int $currentId, string $currentDate): ?array
    {
        $sql = 'SELECT id, titre, slug
                FROM articles
                WHERE statut = :statut
                  AND (date > :date OR (date = :date AND id > :id))
                ORDER BY date ASC, id ASC
                LIMIT 1';

        $stmt = db()->prepare($sql);
        $stmt->execute([
            'statut' => 'publie',
            'date' => $currentDate,
            'id' => $currentId,
        ]);

        $article = $stmt->fetch(PDO::FETCH_ASSOC);
        return is_array($article) ? $article : null;
    }

    /** @param array<string,mixed> $data */
    public static function create(array $data): void
    {
        $slug = !empty($data['slug']) ? $data['slug'] : slugify((string) $data['titre']);
        $sql = 'INSERT INTO articles (id_categorie, titre, slug, contenu, image, nom_auteur, statut, meta_title, meta_description)
                VALUES (:id_categorie, :titre, :slug, :contenu, :image, :nom_auteur, :statut, :meta_title, :meta_description)';

        $stmt = db()->prepare($sql);
        $stmt->execute([
            'id_categorie' => $data['id_categorie'],
            'titre' => $data['titre'],
            'slug' => $slug,
            'contenu' => $data['contenu'],
            'image' => $data['image'],
            'nom_auteur' => $data['nom_auteur'],
            'statut' => $data['statut'],
            'meta_title' => $data['meta_title'],
            'meta_description' => $data['meta_description'],
        ]);
    }

    /** @param array<string,mixed> $data */
    public static function update(int $id, array $data): void
    {
        $slug = !empty($data['slug']) ? $data['slug'] : slugify((string) $data['titre']);
        $sql = 'UPDATE articles
                SET id_categorie = :id_categorie,
                    titre = :titre,
                    slug = :slug,
                    contenu = :contenu,
                    image = :image,
                    nom_auteur = :nom_auteur,
                    statut = :statut,
                    meta_title = :meta_title,
                    meta_description = :meta_description
                WHERE id = :id';

        $stmt = db()->prepare($sql);
        $stmt->execute([
            'id_categorie' => $data['id_categorie'],
            'titre' => $data['titre'],
            'slug' => $slug,
            'contenu' => $data['contenu'],
            'image' => $data['image'],
            'nom_auteur' => $data['nom_auteur'],
            'statut' => $data['statut'],
            'meta_title' => $data['meta_title'],
            'meta_description' => $data['meta_description'],
            'id' => $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $stmt = db()->prepare('DELETE FROM articles WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }
}
