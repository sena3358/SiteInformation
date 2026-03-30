# Plan d'action - Site d'actualites (Iran)

## 1. Lancement du projet

But : disposer d'une base technique fiable des le debut.

- [ ] Ouvrir un depot public sur GitHub ou GitLab
- [ ] Mettre en route Docker avec :
	- [ ] Un service PHP + Apache
	- [ ] Un service MySQL
- [ ] Ajouter un fichier `.env` pour centraliser les parametres (BDD, ports, etc.)
- [ ] Confirmer que l'environnement tourne via une page `phpinfo()`

Organisation conseillee :

- [ ] Creer le dossier `app/`
- [ ] Creer le dossier `public/` pour le FrontOffice
- [ ] Creer le dossier `admin/` pour le BackOffice
- [ ] Creer le dossier `core/` pour la connexion BDD et les fonctions communes
- [ ] Creer le dossier `templates/` pour les blocs header/footer
- [ ] Creer le dossier `assets/` pour CSS, JS et images

## 2. Modelisation de la base de donnees

But : organiser les informations du site de maniere propre et evolutive.

Tables a preparer :

- [ ] `categories` (id, libelle)
- [ ] `articles` (id, id_categorie, titre, contenu, image, date, nom_auteur, statut, vue_count, meta_title, meta_description)
- [ ] `users` (id, username, password, role)

Actions a realiser :

- [ ] Rediger le script SQL d'initialisation (`init.sql`)
- [ ] Inserer des donnees de depart :
	- [ ] 1 compte admin avec mot de passe securise
	- [ ] Plusieurs categories et articles exemples
- [ ] Verifier que les relations entre tables fonctionnent correctement

## 3. Construction du BackOffice

But : permettre l'administration complete du contenu.

### Connexion admin

- [x] Construire l'ecran de login
- [x] Controler les identifiants avec PDO et bonnes pratiques de securite
- [x] Mettre en place la gestion de session
- [x] Bloquer l'acces aux pages privees pour les non-authentifies

### Administration des articles

- [x] Ajouter un article
- [x] Editer un article
- [x] Supprimer un article
- [x] Gerer l'etat de publication (publie / brouillon)

### Administration des categories

- [x] Creer, modifier et supprimer des categories

### Ergonomie de l'interface

- [ ] Ajouter un menu clair (articles, categories, deconnexion)
- [ ] Afficher l'utilisateur actuellement connecte
- [ ] Garder une interface simple, lisible et fonctionnelle

## 4. Construction du FrontOffice

But : presenter les contenus de facon claire aux visiteurs.

Pages essentielles :

- [x] Accueil : liste des articles les plus recents
- [x] Fiche article : contenu complet
- [x] Page categorie : affichage filtre des articles

Fonctions attendues :

- [x] Charger les contenus de facon dynamique depuis la BDD
- [x] Incrementer un compteur de vues par article
- [x] Ajouter la navigation entre articles
- [x] Afficher image, titre, texte, date et auteur

## 5. Referencement naturel (SEO)

But : ameliorer la visibilite du site sur les moteurs de recherche.

- [ ] Configurer le rewriting d'URL via `.htaccess`
- [ ] Utiliser des slugs lisibles dans les liens
- [ ] Soigner les balises HTML :
	- [ ] Un `title` pertinent et unique par page
	- [ ] Une `meta description` adaptee
	- [ ] Un seul `h1` par page
- [ ] Respecter une hierarchie de titres coherente (`h2`, `h3`...)
- [ ] Ajouter `alt` sur toutes les images
- [ ] Utiliser des ancres de liens explicites

Optimisations supplementaires :

- [ ] Definir des URL canoniques pour limiter le contenu duplique
- [ ] Gerer les directives `meta robots` (index/noindex)
- [ ] Generer `sitemap.xml`
- [ ] Configurer `robots.txt`
- [ ] Ajouter des donnees structurees JSON-LD (type Article)

## 6. Optimisation des performances

But : reduire les temps de chargement.

- [ ] Activer la compression Gzip
- [ ] Mettre en place un mecanisme de cache (headers ou fichiers)
- [ ] Compresser et redimensionner les images
- [ ] Minifier les fichiers CSS et JS
- [ ] Verifier un affichage responsive en approche mobile-first

## 7. Recette et validation

But : garantir la qualite globale avant livraison.

- [ ] Executer Lighthouse en mode desktop
- [ ] Executer Lighthouse en mode mobile
- [ ] Examiner les scores :
	- [ ] Performance
	- [ ] SEO
- [ ] Corriger les anomalies remontees

Points de controle :

- [ ] Verifier les codes HTTP (200, 301, 404)
- [ ] Valider les redirections
- [ ] Corriger tous les liens casses

## 8. Documentation technique

But : fournir un dossier de projet clair et exploitable.

Elements a inclure :

- [ ] Resume du projet
- [ ] Vue d'ensemble de l'architecture
- [ ] Schema de la base de donnees
- [ ] Captures d'ecran du FrontOffice et du BackOffice
- [ ] Identifiants administrateur de test
- [ ] Procedure de lancement Docker

## 9. Livraison du projet

But : remettre un rendu stable et operationnel.

- [ ] Lancer un test complet avec `docker-compose up --build`
- [ ] Verifier le parcours fonctionnel de bout en bout
- [ ] Creer l'archive ZIP finale
- [ ] Partager le lien du depot Git
- [ ] Deposer le projet sur la plateforme de rendu

## Bonus (si le planning le permet)

- [ ] Mettre en place une pagination des articles
- [ ] Ajouter une fonctionnalite de recherche
- [ ] Renforcer la securite (XSS, injection SQL)
- [ ] Ameliorer l'interface utilisateur
