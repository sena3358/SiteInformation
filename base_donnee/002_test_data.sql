-- Insertion massive de 500 000 articles (PostgreSQL)
-- Compatible avec le schema actuel: articles(id_categorie, titre, contenu, image, date, nom_auteur, statut, vue_count, meta_title, meta_description)

BEGIN;

WITH cat_ids AS (
    SELECT array_agg(id ORDER BY id) AS ids
    FROM categories
),
rows_to_insert AS (
    SELECT gs AS n
    FROM generate_series(1, 500000) AS gs
)
INSERT INTO articles (
    id_categorie,
    titre,
    contenu,
    image,
    date,
    nom_auteur,
    statut,
    vue_count,
    meta_title,
    meta_description
)
SELECT
    CASE
        WHEN cat_ids.ids IS NULL OR array_length(cat_ids.ids, 1) IS NULL THEN NULL
        ELSE cat_ids.ids[1 + floor(random() * array_length(cat_ids.ids, 1))::int]
    END AS id_categorie,
    'Article #' || n || ' - ' ||
    (ARRAY['Politique','Economie','Societe','International','Technologie','Culture','Sport'])[1 + floor(random() * 7)::int] AS titre,
    'Contenu genere automatiquement pour l''article #' || n || '. '
    || 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. '
    || 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' AS contenu,
    '/assets/images/article-' || ((n % 24) + 1) || '.jpg' AS image,
    NOW() - (random() * interval '730 days') AS date,
    (ARRAY['Redaction','Equipe Eco','Desk Tech','Culture Mag','Sport News'])[1 + floor(random() * 5)::int] AS nom_auteur,
    CASE WHEN random() < 0.8 THEN 'publie' ELSE 'brouillon' END AS statut,
    floor(random() * 50000)::int AS vue_count,
    'Meta title article #' || n AS meta_title,
    'Meta description auto pour article #' || n || '.' AS meta_description
FROM rows_to_insert
CROSS JOIN cat_ids;

COMMIT;
