-- Donnees de test pour le projet newsdb
-- Ce script est idempotent: il peut etre rejoue sans dupliquer les lignes principales.

-- Categories supplementaires
INSERT INTO categories (libelle)
VALUES
    ('International'),
    ('Technologie'),
    ('Culture'),
    ('Sport')
ON CONFLICT (libelle) DO NOTHING;

-- Utilisateurs de test
INSERT INTO users (username, password, role)
VALUES
    ('editor1', 'editor123', 'editor'),
    ('editor2', 'editor123', 'editor'),
    ('moderator1', 'mod123', 'moderator'),
    ('visiteur1', 'visiteur123', 'visitor')
ON CONFLICT (username) DO NOTHING;

-- Articles de test
INSERT INTO articles (
    id_categorie,
    titre,
    contenu,
    image,
    nom_auteur,
    statut,
    vue_count,
    meta_title,
    meta_description
)
SELECT
    c.id,
    'Elections regionales: les enjeux a surveiller',
    'Un tour d''horizon des principaux enjeux politiques et economiques de ces elections.',
    '/assets/images/elections.jpg',
    'Redaction',
    'publie',
    124,
    'Elections regionales - Analyse',
    'Analyse des enjeux des elections regionales et de leurs impacts.'
FROM categories c
WHERE c.libelle = 'Politique'
  AND NOT EXISTS (
      SELECT 1 FROM articles a WHERE a.titre = 'Elections regionales: les enjeux a surveiller'
  );

INSERT INTO articles (
    id_categorie,
    titre,
    contenu,
    image,
    nom_auteur,
    statut,
    vue_count,
    meta_title,
    meta_description
)
SELECT
    c.id,
    'Inflation: comment les foyers s''adaptent',
    'Face a la hausse des prix, les menages ajustent leurs habitudes de consommation.',
    '/assets/images/inflation.jpg',
    'Equipe Eco',
    'publie',
    87,
    'Inflation et budget des foyers',
    'Decryptage des effets de l''inflation sur le budget quotidien.'
FROM categories c
WHERE c.libelle = 'Economie'
  AND NOT EXISTS (
      SELECT 1 FROM articles a WHERE a.titre = 'Inflation: comment les foyers s''adaptent'
  );

INSERT INTO articles (
    id_categorie,
    titre,
    contenu,
    image,
    nom_auteur,
    statut,
    vue_count,
    meta_title,
    meta_description
)
SELECT
    c.id,
    'IA generative: usages concrets en entreprise',
    'Panorama des cas d''usage de l''IA generative dans les operations et le support client.',
    '/assets/images/ia-entreprise.jpg',
    'Desk Tech',
    'brouillon',
    12,
    'IA generative en entreprise',
    'Exemples concrets de deploiement de l''IA generative.'
FROM categories c
WHERE c.libelle = 'Technologie'
  AND NOT EXISTS (
      SELECT 1 FROM articles a WHERE a.titre = 'IA generative: usages concrets en entreprise'
  );

INSERT INTO articles (
    id_categorie,
    titre,
    contenu,
    image,
    nom_auteur,
    statut,
    vue_count,
    meta_title,
    meta_description
)
SELECT
    c.id,
    'Festival de cinema: le palmares complet',
    'Retour sur les films recompenses et les temps forts du festival.',
    '/assets/images/festival-cinema.jpg',
    'Culture Mag',
    'publie',
    45,
    'Palmares du festival de cinema',
    'Tous les laureats du festival et les moments marquants.'
FROM categories c
WHERE c.libelle = 'Culture'
  AND NOT EXISTS (
      SELECT 1 FROM articles a WHERE a.titre = 'Festival de cinema: le palmares complet'
  );
