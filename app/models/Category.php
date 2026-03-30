<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

final class Category
{
    /** @return list<array{id:int,libelle:string}> */
    public static function all(): array
    {
        $stmt = db()->query('SELECT id, libelle FROM categories ORDER BY libelle ASC');
        /** @var list<array{id:int,libelle:string}> $rows */
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
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
}
