<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

final class Setting
{
    /** @var array<string,string> */
    private static array $cache = [];

    public static function get(string $key, string $default = ''): string
    {
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        $stmt = db()->prepare('SELECT valeur FROM settings WHERE cle = :cle LIMIT 1');
        $stmt->execute(['cle' => $key]);
        $result = $stmt->fetchColumn();

        $value = is_string($result) ? $result : $default;
        self::$cache[$key] = $value;

        return $value;
    }

    public static function getCountry(): string
    {
        return self::get('site_country', 'Iran');
    }

    public static function getSiteName(): string
    {
        return self::get('site_name', 'Actualites');
    }
}
