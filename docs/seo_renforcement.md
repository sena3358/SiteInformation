# Renforcement SEO du Site d'Information

Ce document resume les modifications apportees au projet pour ameliorer le referencement (SEO) du site.

---

## 1. URLs Normalisees (URL Rewriting)

### Objectif
Transformer les URLs techniques en URLs lisibles et optimisees pour les moteurs de recherche.

### Avant
```
/article/123
```

### Apres
```
/article/123-titre-de-larticle
```

### Modifications apportees

| Fichier | Description |
|---------|-------------|
| `base_donnee/001_schema.sql` | Ajout de la colonne `slug` dans la table `articles` |
| `app/config/bootstrap.php` | Ajout de la fonction `slugify()` pour generer des slugs |
| `app/models/Article.php` | Ajout de la methode `Article::url()` et gestion des slugs |
| `app/routes/frontoffice/web.php` | Route modifiee pour accepter le format `{id}-{slug}` |
| `app/controllers/frontoffice/FrontArticleController.php` | Redirection 301 vers l'URL canonique si le slug est incorrect |

### Fonction slugify()

```php
function slugify(string $text): string
{
    $text = mb_strtolower($text, 'UTF-8');
    // Remplacement des caracteres accentues
    $replacements = [
        'a' => ['a', 'a', 'a', 'a', 'a', 'a', 'ae'],
        'e' => ['e', 'e', 'e', 'e'],
        // ...
    ];
    // Suppression des caracteres speciaux
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}
```

### Redirection 301

Lorsqu'un utilisateur accede a `/article/123` ou `/article/123-mauvais-slug`, le systeme redirige automatiquement vers l'URL canonique `/article/123-bon-slug` avec un code HTTP 301 (redirection permanente).

---

## 2. Structure Semantique h1/h2/.../h6

### Objectif
Respecter la hierarchie des titres HTML pour une meilleure comprehension par les moteurs de recherche.

### Regle appliquee
- **1 seul `<h1>` par page** : Le titre principal de la page
- **`<h2>`** : Sections principales
- **`<h3>`** : Sous-sections

### Structure par page

| Page | h1 | h2 |
|------|----|----|
| Accueil (`home.php`) | "Actualites - {Pays}" | "Categories", "Articles recents" |
| Article (`show.php`) | Titre de l'article | - |
| Categorie (`category.php`) | "Categorie: {Nom}" | Titres des articles (dans la liste) |
| Connexion (`login.php`) | "Connexion visiteur" | - |
| Mon compte (`account.php`) | "Mon compte" | - |

---

## 3. Balises Title Dynamiques

### Objectif
Chaque page doit avoir un titre unique et descriptif qui apparait dans l'onglet du navigateur et les resultats de recherche.

### Format adopte
```
{Titre specifique} | {Nom du site}
```

### Exemples

| Page | Balise Title |
|------|--------------|
| Accueil | "Actualites recentes \| Actualites Iran" |
| Article | "Titre de l'article \| Actualites Iran" |
| Categorie | "Categorie Politique \| Actualites Iran" |
| Connexion | "Connexion \| Actualites Iran" |
| Mon compte | "Mon compte \| Actualites Iran" |

### Implementation

```php
<title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?> | <?= htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8') ?></title>
```

---

## 4. Balises Meta Description

### Objectif
Fournir un resume de la page qui apparait dans les resultats de recherche Google.

### Longueur recommandee
Entre 150 et 160 caracteres.

### Implementation par page

**Accueil (`home.php`)** :
```html
<meta name="description" content="Suivez les dernieres actualites sur la situation en {pays}. Articles, analyses et informations.">
```

**Article (`show.php`)** :
```html
<meta name="description" content="{meta_description de l'article ou extrait automatique de 160 caracteres}">
```

**Categorie (`category.php`)** :
```html
<meta name="description" content="Tous les articles de la categorie {nom} sur {pays}. {X} articles disponibles.">
```

**Connexion (`login.php`)** :
```html
<meta name="description" content="Connectez-vous pour acceder a votre espace personnel sur {nom du site}.">
```

### Generation automatique

Si un article n'a pas de `meta_description` definie, le systeme genere automatiquement un extrait des 160 premiers caracteres du contenu :

```php
$metaDesc = ($article['meta_description'] ?? '');
if ($metaDesc === '') {
    $metaDesc = mb_substr(strip_tags($article['contenu']), 0, 160) . '...';
}
```

---

## 5. Attributs Alt pour les Images

### Objectif
Decrire les images pour les moteurs de recherche et l'accessibilite (lecteurs d'ecran).

### Implementation

Toutes les images du site ont un attribut `alt` descriptif :

```php
<img src="<?= htmlspecialchars($article['image']) ?>"
     alt="Illustration de l'article <?= htmlspecialchars($article['titre']) ?>">
```

### Bonnes pratiques appliquees
- Description contextuelle de l'image
- Inclusion du titre de l'article pour les images d'illustration
- Pas de texte generique comme "image" ou "photo"

---

## 6. Pays Parametrable (Configuration)

### Objectif
Permettre de changer facilement le pays du site sans modifier le code.

### Implementation

**Table `settings` en base de donnees** :

```sql
CREATE TABLE settings (
    cle VARCHAR(100) PRIMARY KEY,
    valeur TEXT NOT NULL
);

INSERT INTO settings (cle, valeur) VALUES
    ('site_country', 'Iran'),
    ('site_name', 'Actualites Iran');
```

**Modele `Setting.php`** :

```php
final class Setting
{
    public static function get(string $key, string $default = ''): string
    public static function getCountry(): string  // Retourne 'Iran' par defaut
    public static function getSiteName(): string // Retourne 'Actualites' par defaut
}
```

### Pour changer le pays

Executez simplement cette requete SQL :

```sql
UPDATE settings SET valeur = 'Ukraine' WHERE cle = 'site_country';
UPDATE settings SET valeur = 'Actualites Ukraine' WHERE cle = 'site_name';
```

Le site refletera immediatement le changement sur toutes les pages.

---

## 7. Sitemap XML et Robots.txt

### Objectif
Permettre aux moteurs de recherche de decouvrir et explorer efficacement le site.

### Sitemap.xml

**Fichier** : `public/sitemap.xml.php` (et route `/sitemap.xml`)

Le sitemap XML est genere dynamiquement et contient :
- **Page d'accueil** : Priorite 1.0, frequence journaliere
- **Articles** : Priorite 0.8, frequence hebdomadaire (jusqu'a 50 000 articles)
- **Categories** : Priorite 0.7, frequence journaliere

```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>http://localhost:8080/mvc</loc>
        <lastmod>2026-03-30</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    ...
</urlset>
```

**Utilisation** :
- Le sitemap est accessible a `/sitemap.xml`
- Peut etre reference dans `robots.txt`
- Permet a Google de decouvrirrapidement nouveaux articles

### Robots.txt

**Fichier** : `public/robots.txt`

Contenu :
```
User-agent: *
Allow: /

# Sitemap
Sitemap: http://localhost:8080/sitemap.xml

# Delay entre les requetes
Crawl-delay: 1
```

**Fonction** :
- Autorise les bots a crawler tous les chemins (`Allow: /`)
- Reference le sitemap XML
- Definit un delai de 1 seconde entre les requetes pour eviter une surcharge serveur

---

## 8. Codes HTTP Appropriés

### Objectif
Communiquer correctement avec les moteurs de recherche sur l'etat des ressources.

### Codes HTTP implementes

| Code | Description | Utilisation |
|------|-------------|------------|
| **200** | OK | Reponse par defaut pour les pages valides |
| **301** | Moved Permanently | Redirection canonique pour URLs avec slug incorrect |
| **302** | Found | Redirection temporaire (par defaut, ex: apres connexion) |
| **404** | Not Found | Article/categorie introuvable ou supprime |
| **410** | Gone | Ressource supprimee definitivement |

### Implementation

**Dans bootstrap.php** :
```php
// Code 200 : par defaut
app_set_status(200);

// Code 404 : article non trouve
if ($article === null) {
    app_halt(404, 'Article introuvable.');
}

// Code 301 : redirection canonique
if ($urlSlug !== $expectedSlug) {
    app_redirect(Article::url($article), 301);
}

// Code 410 : ressource supprimee (nouveau)
function app_gone(int $statusCode = 410, string $message = 'Cette ressource n\'est plus disponible.'): void
{
    app_halt($statusCode, $message);
}
```

**Impact SEO** :
- 404 indique aux bots qu'une page n'existe pas (pas d'erreur)
- 410 indique qu'une page existait mais a ete supprimee definitivement (pas de re-indexation)
- 301 preserve l'autorite SEO lors de redirections canoniques

---

## 9. Eviter les Redirect Chains

### Objectif
Optimiser le crawl budget en evitant les chaines de redirections inutiles.

### Implementation

**Controle dans FrontArticleController::show()** :

Le systeme verifie directement le slug attendu et redirige en une seule etape :

```php
// Pas de chaine de redirection : redirection directe vers l'URL canonique
$expectedSlug = !empty($article['slug']) ? $article['slug'] : slugify((string) $article['titre']);
if ($urlSlug !== $expectedSlug) {
    app_redirect(Article::url($article), 301);  // Redirection directe
}
```

**Avantages** :
- Une redirection 301 directe = meilleure experience utilisateur
- Preserve davantage l'autorite SEO
- Consomme moins de ressources serveur

---

## 10. Lazy Loading des Images

### Objectif
Ameliorer les performances de chargement et l'experience utilisateur.

### Implementation

**Ajout de `loading="lazy"` aux images** :

```html
<img src="image.jpg"
     alt="Description"
     loading="lazy">
```

**Pages modifiees** :
- `app/views/frontoffice/home.php` : Lazy loading sur images d'articles
- `app/views/frontoffice/article/show.php` : Lazy loading sur image hero
- `app/views/frontoffice/article/category.php` : Lazy loading sur images de liste

**Impact** :
- Reduction du temps de chargement initial
- Chargement des images uniquement quand elles deviennent visibles
- Reduction de la bande passante
- Meilleur score Lighthouse (Core Web Vitals)

### Support navigateur
- Chrome 76+
- Firefox 75+
- Safari 15.1+
- Edge 79+



## Liste des Fichiers Modifies

### Base de donnees
| Fichier | Modification |
|---------|--------------|
| `base_donnee/001_schema.sql` | + table `settings`, + colonne `slug` |
| `base_donnee/003_seo_migration.sql` | Script de migration pour bases existantes |

### Modeles
| Fichier | Modification |
|---------|--------------|
| `app/models/Setting.php` | **Nouveau** - Gestion des parametres |
| `app/models/Article.php` | + methode `url()`, + gestion slugs dans SELECT/INSERT/UPDATE |

### Configuration
| Fichier | Modification |
|---------|--------------|
| `app/config/bootstrap.php` | + fonction `slugify()`, + fonction `app_gone()` |
| `app/controllers/SitemapController.php` | **Nouveau** - Genere le sitemap XML |

### Routes et Fichiers publics
| Fichier | Modification |
|---------|--------------|
| `app/routes/frontoffice/web.php` | Route `/article/@slug`, route `/sitemap.xml` |
| `public/robots.txt` | **Nouveau** - Configuration pour bots |
| `public/sitemap.xml.php` | **Nouveau** - Sitemap XML dynamique |

### Controleurs
| Fichier | Modification |
|---------|--------------|
| `FrontArticleController.php` | Parsing slug, redirection 301, passage settings |
| `HomeController.php` | Passage settings aux vues |
| `VisitorAuthController.php` | Passage settings aux vues |

### Vues
| Fichier | Modification |
|---------|--------------|
| `home.php` | + meta description, + h1 unique, + URLs SEO, + lazy loading |
| `article/show.php` | + title avec site name, + meta auto-generee, + URLs SEO, + lazy loading |
| `article/category.php` | + title, + meta description, + URLs SEO, + lazy loading |
| `visitor/login.php` | + title, + meta description, + h1 |
| `visitor/account.php` | + title, + meta description, + styles |

---

## Verification SEO

### Checklist

- [ ] Chaque page a un seul `<h1>`
- [ ] Le `<title>` contient le nom du site
- [ ] La `<meta name="description">` est presente et unique
- [ ] Les images ont un attribut `alt` descriptif
- [ ] Les URLs des articles contiennent un slug lisible
- [ ] La redirection 301 fonctionne pour les anciennes URLs

### Outils recommandes

1. **Inspecteur du navigateur** : Verifier le HTML genere
2. **Google Search Console** : Suivre l'indexation
3. **Lighthouse** : Audit SEO automatise (onglet DevTools)

---

## Impact SEO Attendu

| Critere | Avant | Apres |
|---------|-------|-------|
| URLs lisibles | Non | Oui |
| Hierarchie h1-h6 | Inconstante | Respectee |
| Balises title | Generiques | Uniques et descriptives |
| Meta description | Absentes | Presentes partout |
| Alt images | Partiellement | Systematique |
| Configuration pays | Code en dur | Base de donnees |
| Sitemap XML | Absent | Dynamique et mise a jour auto |
| Robots.txt | Absent | Presente et optimise |
| Codes HTTP | Partiels | 200, 301, 302, 404, 410 |
| Redirect chains | Non optimise | Redirection directe |
| Performance images | Chargement synchrone | Lazy loading (Web Vitals) |

Ces modifications permettent une meilleure comprehension du contenu par les moteurs de recherche, ameliorent le positionnement dans les resultats de recherche et offrent une meilleure experience utilisateur.
