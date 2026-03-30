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
| `app/config/bootstrap.php` | + fonction `slugify()` |

### Routes
| Fichier | Modification |
|---------|--------------|
| `app/routes/frontoffice/web.php` | Route `/article/@slug` |

### Controleurs
| Fichier | Modification |
|---------|--------------|
| `FrontArticleController.php` | Parsing slug, redirection 301, passage settings |
| `HomeController.php` | Passage settings aux vues |
| `VisitorAuthController.php` | Passage settings aux vues |

### Vues
| Fichier | Modification |
|---------|--------------|
| `home.php` | + meta description, + h1 unique, + URLs SEO |
| `article/show.php` | + title avec site name, + meta auto-generee, + URLs SEO |
| `article/category.php` | + title, + meta description, + URLs SEO |
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

Ces modifications permettent une meilleure comprehension du contenu par les moteurs de recherche et ameliorent le positionnement dans les resultats de recherche.
