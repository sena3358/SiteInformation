-- Contenus exemplaires frontoffice (theme: guerre en Iran)
-- Script idempotent: insertion uniquement si le slug n'existe pas.

BEGIN;

WITH cats AS (
    SELECT id, LOWER(libelle) AS key
    FROM categories
), prepared AS (
    SELECT * FROM (
        VALUES
            (
                'Iran: pression militaire et diplomatique dans le Golfe persique',
                'iran-pression-militaire-diplomatique-golfe-persique',
                'international',
                'Desk International',
                '/assets/images/618748.jpg',
                'Point de situation au 31 mars 2026\n\nLa semaine a ete marquee par une hausse des incidents maritimes autour du Golfe persique, avec plusieurs alertes de securite emises pour les couloirs commerciaux strategiques. Les compagnies de fret ont adapte leurs routes, ce qui augmente les delais logistiques et les couts d''assurance.\n\nCe que disent les analystes\n\nLes experts soulignent que la tension repose autant sur la dissuasion militaire que sur la guerre de l''information. Les declarations officielles sont souvent suivies de corrections, ce qui rend la verification independante essentielle.\n\nImpact regional\n\nLes pays voisins renforcent les controles frontaliers et accelerent la coordination diplomatique pour eviter une escalade directe. Sur le plan economique, l''incertitude pese sur les prix de l''energie et la confiance des investisseurs.\n\nA surveiller\n\n- Evolution des discussions diplomatiques multilaterales\n- Niveau d''activite navale dans les zones sensibles\n- Stabilite des infrastructures energetiques',
                'Contexte complet sur la pression militaire et diplomatique autour de l''Iran: securite maritime, enjeux regionaux et perspectives a court terme.'
            ),
            (
                'Civils deplaces: comment les villes frontieres s''organisent en Iran',
                'civils-deplaces-villes-frontieres-organisation-iran',
                'societe',
                'Cellule Terrain',
                '/assets/images/618748.jpg',
                'Des besoins humanitaires en hausse\n\nDans plusieurs provinces proches des zones de tension, les autorites locales et les associations ont ouvert des centres temporaires pour accueillir les familles deplacees. Les besoins prioritaires concernent l''hebergement, les soins de base et la continuite scolaire des enfants.\n\nOrganisation locale\n\nLes municipalites ont mis en place des cellules de coordination avec des medecins, des travailleurs sociaux et des benevoles. L''objectif est de centraliser l''orientation des personnes vulnerables et de fluidifier la distribution de l''aide.\n\nDefis persistants\n\nLe manque de transport, la rarete de certains medicaments et la fatigue psychologique compliquent la gestion quotidienne. Les ONG demandent un appui plus stable pour les structures locales.\n\nPerspective\n\nLa resilience des reseaux de proximite reste un facteur cle pour limiter les ruptures sociales si la crise se prolonge.',
                'Reportage sur la situation des civils deplaces en Iran: hebergement, aide locale, defis sanitaires et organisation des villes frontieres.'
            ),
            (
                'Energie sous tension: pourquoi le conflit en Iran inquiete les marches',
                'energie-sous-tension-conflit-iran-inquiete-marches',
                'economie',
                'Desk Economie',
                '/assets/images/wallpaperflare.com_wallpaper%20(9).jpg',
                'Un risque geopolitique majeur\n\nLes marches integrent rapidement les risques lies a la securite des routes energetiques et des sites industriels. Les variations de prix sont accentuees par les anticipations contradictoires sur la duree de la crise.\n\nTrois canaux d''impact\n\n1) Transport maritime: primes d''assurance en hausse.\n2) Approvisionnement regional: retards et incertitudes contractuelles.\n3) Sentiment des investisseurs: volatilite accrue sur les actifs sensibles a l''energie.\n\nCe que cela change pour les entreprises\n\nLes groupes importateurs renforcent leur couverture de risque et revoient leurs stocks strategiques. Les entreprises de transport renegocient leurs clauses de securite.\n\nScenario central\n\nLes economistes envisagent un choc de court terme, avec un retour progressif a la normale si les canaux diplomatiques restent actifs.',
                'Analyse economique des effets de la guerre en Iran sur les prix de l''energie, la logistique maritime et la volatilite des marches.'
            ),
            (
                'Cyberattaques et desinformation: le second front de la guerre en Iran',
                'cyberattaques-desinformation-second-front-guerre-iran',
                'technologie',
                'Desk Tech',
                '/assets/images/618748.jpg',
                'Le conflit se joue aussi en ligne\n\nEn parallele des operations sur le terrain, plusieurs campagnes numeriques visent les infrastructures, les plateformes mediatiques et la confiance du public. Les experts notent une multiplication des faux contenus et des tentatives de saturation informationnelle.\n\nMethodes observees\n\n- Diffusion de rumeurs via comptes relais automatises\n- Recyclage d''images anciennes presentees comme recentes\n- Tentatives de perturbation de services publics numeriques\n\nComment verifier\n\nLa verification croisee des sources, la geolocalisation d''images et l''analyse des horodatages restent les outils les plus efficaces contre la manipulation.\n\nEnjeu majeur\n\nLa capacite a distinguer information confirmee et recit de propagande conditionne la qualite du debat public en periode de crise.',
                'Dossier sur le front numerique de la guerre en Iran: cyberattaques, propagande en ligne, verification des sources et securite informationnelle.'
            ),
            (
                'Negociations en coulisses: quels leviers diplomatiques pour eviter l''escalade',
                'negociations-coulisses-leviers-diplomatiques-eviter-escalade',
                'politique',
                'Desk Politique',
                '/assets/images/618748.jpg',
                'Des canaux discrets mais actifs\n\nMalgre les tensions publiques, plusieurs interlocuteurs internationaux poursuivent des contacts indirects pour contenir l''escalade. Les discussions portent sur des mesures de deconfliction, la protection des civils et la securisation des infrastructures critiques.\n\nLeviers identifies\n\n- Mecanismes d''alerte rapide entre acteurs regionaux\n- Garanties de non-ciblage de certaines zones sensibles\n- Appui d''organisations multilaterales pour structurer un calendrier de dialogue\n\nFreins a la desescalade\n\nLa pression politique interne, la concurrence des recits nationaux et la mefiance historique ralentissent les compromis.\n\nCe qui peut faire basculer la dynamique\n\nUn accord technique limite, meme partiel, pourrait restaurer un minimum de confiance operationnelle.',
                'Lecture politique des leviers diplomatiques autour de l''Iran: deconfliction, mediation regionale et conditions d''une desescalade.'
            ),
            (
                'Sur le terrain: chronologie d''une semaine de tensions en Iran',
                'sur-terrain-chronologie-semaine-tensions-iran',
                'international',
                'Redaction Centrale',
                '/assets/images/wallpaperflare.com_wallpaper%20(9).jpg',
                'Lundi\n\nMultiplication des alertes de securite et premiers ajustements logistiques dans la region.\n\nMardi\n\nNouvelles prises de position diplomatiques, avec des messages parfois contradictoires entre acteurs internationaux.\n\nMercredi\n\nHausse de la vigilance autour des infrastructures critiques et renforcement des protocoles de securite civile.\n\nJeudi\n\nContacts diplomatiques informels confirmes par plusieurs sources concordantes.\n\nVendredi\n\nStabilisation relative, sans recul net des tensions operationnelles.\n\nLecture globale\n\nLa semaine illustre une crise hybride: pression militaire, bataille informationnelle et negociation continue en arriere-plan.',
                'Chronologie complete d''une semaine de guerre en Iran: faits verifies, signaux diplomatiques et evolution des tensions sur le terrain.'
            )
    ) AS t(titre, slug, cat_key, auteur, image, contenu, meta_description)
)
INSERT INTO articles (
    id_categorie,
    titre,
    slug,
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
    c.id,
    p.titre,
    p.slug,
    p.contenu,
    p.image,
    NOW() - (ROW_NUMBER() OVER (ORDER BY p.titre) * INTERVAL '3 hours'),
    p.auteur,
    'publie',
    0,
    p.titre,
    p.meta_description
FROM prepared p
LEFT JOIN cats c ON c.key = p.cat_key
WHERE NOT EXISTS (
    SELECT 1
    FROM articles a
    WHERE a.slug = p.slug
);

COMMIT;
