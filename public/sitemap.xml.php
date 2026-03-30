<?php
/**
 * Sitemap XML dynamique
 * Génère la liste des URLs à indexer pour les moteurs de recherche
 */

declare(strict_types=1);

require_once __DIR__ . '/../app/config/database.php';

header('Content-Type: application/xml; charset=utf-8');

$baseUrl = 'https://TPsiteInformation.com';
// $baseUrl = 'http://localhost:8080'; // Pour développement local
$lastmod = date('Y-m-d');

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

try {
    // URL de la page d'accueil
    echo "    <url>\n";
    echo "        <loc>" . htmlspecialchars($baseUrl . '/', ENT_QUOTES, 'UTF-8') . "</loc>\n";
    echo "        <lastmod>$lastmod</lastmod>\n";
    echo "        <changefreq>daily</changefreq>\n";
    echo "        <priority>1.0</priority>\n";
    echo "    </url>\n";

    // Les pages articles publiés
    $stmt = db()->query(
        "SELECT id, slug, titre, date FROM articles WHERE statut = 'publie' ORDER BY date DESC LIMIT 50000"
    );
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($articles as $article) {
        $id = (int) $article['id'];
        $slug = htmlspecialchars($article['slug'], ENT_QUOTES, 'UTF-8');
        $date = substr((string) $article['date'], 0, 10);

        echo "    <url>\n";
        echo "        <loc>" . htmlspecialchars("$baseUrl/article/$id-$slug", ENT_QUOTES, 'UTF-8') . "</loc>\n";
        echo "        <lastmod>$date</lastmod>\n";
        echo "        <changefreq>weekly</changefreq>\n";
        echo "        <priority>0.8</priority>\n";
        echo "    </url>\n";
    }

    // Les pages catégories
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
    // En cas d'erreur, retourner une URL par défaut
    echo "    <url>\n";
    echo "        <loc>" . htmlspecialchars($baseUrl . '/', ENT_QUOTES, 'UTF-8') . "</loc>\n";
    echo "        <lastmod>$lastmod</lastmod>\n";
    echo "    </url>\n";
}

echo '</urlset>' . "\n";
