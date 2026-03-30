CREATE TABLE IF NOT EXISTS categories (
    id SERIAL PRIMARY KEY,
    libelle VARCHAR(120) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(80) NOT NULL UNIQUE,
    password TEXT NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'editor'
);

CREATE TABLE IF NOT EXISTS articles (
    id SERIAL PRIMARY KEY,
    id_categorie INTEGER REFERENCES categories(id) ON DELETE SET NULL,
    titre VARCHAR(255) NOT NULL,
    slug VARCHAR(255),
    contenu TEXT NOT NULL,
    image VARCHAR(255),
    date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    nom_auteur VARCHAR(120) NOT NULL,
    statut VARCHAR(20) NOT NULL DEFAULT 'brouillon',
    vue_count INTEGER NOT NULL DEFAULT 0,
    meta_title VARCHAR(255),
    meta_description TEXT
);

CREATE TABLE IF NOT EXISTS settings (
    cle VARCHAR(100) PRIMARY KEY,
    valeur TEXT NOT NULL
);

INSERT INTO categories (libelle)
VALUES
    ('Politique'),
    ('Economie'),
    ('Societe'),
    ('International'),
    ('Technologie'),
    ('Culture'),
    ('Sport')
ON CONFLICT (libelle) DO NOTHING;

INSERT INTO users (username, password, role)
VALUES
    ('admin', 'admin123', 'admin'),
    ('editor1', 'editor123', 'editor'),
    ('editor2', 'editor123', 'editor'),
    ('moderator1', 'mod123', 'moderator'),
    ('visiteur1', 'visiteur123', 'visitor')
ON CONFLICT (username) DO NOTHING;

INSERT INTO settings (cle, valeur)
VALUES
    ('site_country', 'Iran'),
    ('site_name', 'Actualites Iran')
ON CONFLICT (cle) DO NOTHING;
