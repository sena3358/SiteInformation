-- Migration pour ajouter le support SEO (slugs et settings)
-- A executer sur les bases de donnes existantes

-- Ajouter la colonne slug aux articles
ALTER TABLE articles ADD COLUMN IF NOT EXISTS slug VARCHAR(255);

-- Creer la table settings si elle n'existe pas
CREATE TABLE IF NOT EXISTS settings (
    cle VARCHAR(100) PRIMARY KEY,
    valeur TEXT NOT NULL
);

-- Inserer les valeurs par defaut
INSERT INTO settings (cle, valeur)
VALUES
    ('site_country', 'Iran'),
    ('site_name', 'Actualites Iran')
ON CONFLICT (cle) DO NOTHING;

-- Generer les slugs pour les articles existants
-- Cette requete cree un slug basique a partir du titre
UPDATE articles
SET slug = LOWER(
    REGEXP_REPLACE(
        REGEXP_REPLACE(
            TRANSLATE(titre, 'àâäéèêëïîôùûüç', 'aaaeeeeiioouuc'),
            '[^a-zA-Z0-9]+', '-', 'g'
        ),
        '^-|-$', '', 'g'
    )
)
WHERE slug IS NULL OR slug = '';
