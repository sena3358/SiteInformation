<?php

declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

final class SitemapController
{
    public static function xml(): void
    {
        app_set_header('Content-Type', 'application/xml; charset=utf-8');

        // Déterminer le protocole et l'hôte
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'TPsiteInformation.com';
        $baseUrl = $protocol . '://' . $host;
        $lastmod = date('Y-m-d');

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        try {
            // Page d'accueil
            echo "    <url>\n";
            echo "        <loc>" . htmlspecialchars($baseUrl . '/mvc', ENT_QUOTES, 'UTF-8') . "</loc>\n";
            echo "        <lastmod>$lastmod</lastmod>\n";
            echo "        <changefreq>daily</changefreq>\n";
            echo "        <priority>1.0</priority>\n";
            echo "    </url>\n";

            // Articles publiés
            $stmt = db()->query(
                "SELECT id, slug, titre, date FROM articles WHERE statut = 'publie' ORDER BY date DESC LIMIT 50000"
            );
            $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($articles as $article) {
                $id = (int) $article['id'];
                $slug = htmlspecialchars(!empty($article['slug']) ? $article['slug'] : slugify((string) $article['titre']), ENT_QUOTES, 'UTF-8');
                $date = substr((string) $article['date'], 0, 10);

                echo "    <url>\n";
                echo "        <loc>" . htmlspecialchars("$baseUrl/article/$id-$slug", ENT_QUOTES, 'UTF-8') . "</loc>\n";
                echo "        <lastmod>$date</lastmod>\n";
                echo "        <changefreq>weekly</changefreq>\n";
                echo "        <priority>0.8</priority>\n";
                echo "    </url>\n";
            }

            // Catégories
            $stmt = db()->query("SELECT id FROM categories ORDER BY id");
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($categories as $category) {
                $id = (int) $category['id'];

                echo "    <url>\n";
                echo "        <loc>" . htmlspecialchars("$baseUrl/categorie/$id", ENT_QUOTES, 'UTF-8') . "</loc>\n";
                echo "        <lastmod>$lastmod</lastmod>\n";
                echo "        <changefreq>daily</changefreq>\n";
                echo "        <priority>0.7</priority>\n";
                echo "    </url>\n";
            }
        } catch (Exception $e) {
            // URL par défaut en cas d'erreur
            echo "    <url>\n";
            echo "        <loc>" . htmlspecialchars($baseUrl . '/mvc', ENT_QUOTES, 'UTF-8') . "</loc>\n";
            echo "        <lastmod>$lastmod</lastmod>\n";
            echo "    </url>\n";
        }

        echo '</urlset>' . "\n";
    }
}
