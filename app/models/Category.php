<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/bootstrap.php';

final class Category
{
    /** @param array<string,mixed> $category */
    public static function url(array $category): string
    {
        return UrlHelper::category($category);
    }

    /** @return list<array{id:int,libelle:string}> */
    public static function all(): array
    {
        $stmt = db()->query('SELECT id, libelle FROM categories ORDER BY libelle ASC');
        /** @var list<array{id:int,libelle:string}> $rows */
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    /** @return list<array{id:int,libelle:string,published_count:int,last_published_at:string|null}> */
    public static function allWithPublishedStats(): array
    {
        $sql = "SELECT c.id,
                       c.libelle,
                       COUNT(a.id) AS published_count,
                       MAX(a.date) AS last_published_at
                FROM categories c
                LEFT JOIN articles a
                  ON a.id_categorie = c.id
                 AND a.statut = 'publie'
                GROUP BY c.id, c.libelle
                ORDER BY c.libelle ASC";

        $stmt = db()->query($sql);
        /** @var list<array<string,mixed>> $rows */
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($rows as $row) {
            $result[] = [
                'id' => (int) ($row['id'] ?? 0),
                'libelle' => (string) ($row['libelle'] ?? ''),
                'published_count' => (int) ($row['published_count'] ?? 0),
                'last_published_at' => isset($row['last_published_at']) ? (string) $row['last_published_at'] : null,
            ];
        }

        return $result;
    }

    public static function create(string $libelle): void
    {
        $stmt = db()->prepare('INSERT INTO categories (libelle) VALUES (:libelle)');
        $stmt->execute(['libelle' => $libelle]);
    }

    public static function update(int $id, string $libelle): void
    {
        $stmt = db()->prepare('UPDATE categories SET libelle = :libelle WHERE id = :id');
        $stmt->execute([
            'libelle' => $libelle,
            'id' => $id,
        ]);
    }

    public static function delete(int $id): void
    {
        $stmt = db()->prepare('DELETE FROM categories WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public static function countAll(): int
    {
        return (int) db()->query('SELECT COUNT(*) FROM categories')->fetchColumn();
    }

    /** @return array{id:int,libelle:string}|null */
    public static function findById(int $id): ?array
    {
        $stmt = db()->prepare('SELECT id, libelle FROM categories WHERE id = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!is_array($row)) {
            return null;
        }

        return [
            'id' => (int) $row['id'],
            'libelle' => (string) $row['libelle'],
        ];
    }

    /** @return array{id:int,libelle:string}|null */
    public static function findBySlug(string $slug): ?array
    {
        $normalizedSlug = slugify($slug);
        foreach (self::all() as $category) {
            if (slugify((string) $category['libelle']) === $normalizedSlug) {
                return $category;
            }
        }

        return null;
    }
}
