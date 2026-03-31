-- Articles redactionnels bases sur les images locales
-- Compatible avec le schema actuel: articles(id_categorie, titre, contenu, image, date, nom_auteur, statut, vue_count, meta_title, meta_description)

BEGIN;

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
VALUES
    (
        (SELECT id FROM categories WHERE libelle = 'International' LIMIT 1),
        'Tensions regionales: manifestations et presence armee dans plusieurs villes',
        'Des rassemblements ont ete observes dans plusieurs villes, avec des slogans politiques et une forte presence d''armes traditionnelles visibles sur certaines images. Les autorites locales appellent au calme et renforcent les dispositifs de securite autour des rassemblements. Sur le terrain, les organisateurs disent vouloir faire passer un message politique, tandis que des mediations sont annoncees pour eviter une escalation. Les observateurs soulignent un contexte regional tendu et une mobilisation heterogene des groupes presents.',
        '/assets/images/image1.jpg',
        NOW() - interval '2 days',
        'Redaction',
        'publie',
        1842,
        'Tensions regionales et mobilisation de rue',
        'Manifestations et presence armee: les autorites appellent au calme dans un contexte regional tendu.'
    ),
    (
        (SELECT id FROM categories WHERE libelle = 'International' LIMIT 1),
        'Drapeaux et slogans lors d''un rassemblement nocturne',
        'Un rassemblement s''est tenu en soiree, marque par des drapeaux et des prises de parole. La mobilisation s''est deroulee dans un contexte d''incertitude regionale, avec un dispositif de securite renforce aux abords des batiments publics. Des participantes ont explique vouloir exprimer une position politique et soutenir une orientation nationale. Aucun incident majeur n''a ete signale, selon les services locaux.',
        '/assets/images/image2.webp',
        NOW() - interval '3 days',
        'Equipe Monde',
        'publie',
        1298,
        'Rassemblement nocturne et drapeaux',
        'Retour sur une mobilisation en soiree et ses revendications.'
    ),
    (
        (SELECT id FROM categories WHERE libelle = 'International' LIMIT 1),
        'Incendie majeur: un quartier touche par une explosion',
        'Une explosion suivie d''un incendie a embrase plusieurs batiments dans un quartier dense, provoquant d''importantes colonnes de fumee visibles a distance. Les services d''urgence sont intervenus pour contenir le feu, tandis qu''une enquete est ouverte pour determiner l''origine de l''incident. Des habitants evoquent une forte deflagration et des degats materiels considerables. Les autorites n''ont pas encore communique de bilan officiel.',
        '/assets/images/image4.webp',
        NOW() - interval '5 days',
        'Desk International',
        'publie',
        2214,
        'Explosion et incendie urbain',
        'Un important incendie frappe un quartier dense apres une explosion.'
    ),
    (
        (SELECT id FROM categories WHERE libelle = 'Societe' LIMIT 1),
        'Batiment endommage: les riverains face aux consequences',
        'Des degats importants sont visibles sur un batiment touche par un evenement recent. Les riverains parlent d''une onde de choc et de chutes de debris. Les equipes de securite evaluent la stabilite des structures et organisent des perimetres de protection. Une prise en charge psychologique est proposee aux habitants les plus affectes.',
        '/assets/images/image5.jpg',
        NOW() - interval '6 days',
        'Redaction',
        'publie',
        978,
        'Degats materiels et soutien aux habitants',
        'Apres un incident majeur, les riverains font face aux impacts materiels et sociaux.'
    ),
    (
        (SELECT id FROM categories WHERE libelle = 'International' LIMIT 1),
        'Declaration politique: un dirigeant appelle a la retenue',
        'Lors d''une prise de parole officielle, un dirigeant a appele a la retenue et a la desescalade dans un contexte regional delicat. Le discours insiste sur la stabilite et la coordination internationale pour eviter une extension de la crise. Des diplomates ont salue le ton de la declaration, tout en rappelant l''importance de mesures concretes sur le terrain.',
        '/assets/images/image6.webp',
        NOW() - interval '7 days',
        'Equipe Monde',
        'publie',
        1435,
        'Appel a la retenue dans un contexte tendu',
        'Un discours officiel met l''accent sur la stabilite et la cooperation internationale.'
    ),
    (
        (SELECT id FROM categories WHERE libelle = 'International' LIMIT 1),
        'Detroits strategiques: enjeux commerciaux et securitaires',
        'Une carte illustre les points de passage maritimes strategiques reliant plusieurs pays du Golfe. Ces routes concentrent une part importante du commerce energetique mondial, ce qui en fait un enjeu securitaire majeur. Des analystes indiquent que toute perturbation dans la zone aurait des repercussions sur les prix de l''energie et les chaines logistiques.',
        '/assets/images/image7.jpg',
        NOW() - interval '8 days',
        'Desk Eco',
        'publie',
        1102,
        'Routes maritimes et risques geopolitiques',
        'Les detroits strategiques restent au coeur des tensions et des equilibres economiques.'
    ),
    (
        (SELECT id FROM categories WHERE libelle = 'Culture' LIMIT 1),
        'Hommage officiel: recueillement lors d''une ceremonie',
        'Une ceremonie de recueillement a rassemble des responsables et des citoyens. Des gerbes de fleurs ont ete deposees devant un portrait officiel, dans un cadre solennel. Les organisateurs ont souligne l''importance du symbole pour la memoire collective, alors que la population exprime une emotion palpable.',
        '/assets/images/image8.jpg',
        NOW() - interval '9 days',
        'Culture Mag',
        'publie',
        864,
        'Ceremonie officielle et recueillement',
        'Retour sur une ceremonie marquant un moment fort pour la memoire collective.'
    ),
    (
        (SELECT id FROM categories WHERE libelle = 'International' LIMIT 1),
        'Vue satellite: impacts visibles apres un incident militaire',
        'Une image satellite met en evidence des traces d''impact sur une infrastructure isolee. Les experts examinent la chronologie des faits et s''appuient sur des images avant/apres pour evaluer l''etendue des degats. Les autorites n''ont pas encore confirme la nature exacte de l''incident, mais les analyses se multiplient.',
        '/assets/images/image9.jpeg',
        NOW() - interval '10 days',
        'Desk International',
        'publie',
        1920,
        'Analyse satellite d''un site touche',
        'Les images satellitaires montrent des traces d''impact apres un incident.'
    ),
    (
        (SELECT id FROM categories WHERE libelle = 'International' LIMIT 1),
        'Portrait officiel: un dirigeant au coeur de la scene regionale',
        'Un portrait officiel rappelle la place centrale d''un dirigeant dans l''actualite regionale. Les observateurs notent l''importance du symbolisme dans la communication politique, tandis que des annonces sont attendues sur le plan diplomatique. La scene internationale suit de pres les developpements en cours.',
        '/assets/images/image10.webp',
        NOW() - interval '11 days',
        'Redaction',
        'publie',
        1015,
        'Symboles politiques et message officiel',
        'Le symbolisme reste un levier majeur dans la communication politique regionale.'
    ),
    (
        (SELECT id FROM categories WHERE libelle = 'International' LIMIT 1),
        'Apparition televisee: message d''un responsable sur la situation',
        'Dans une allocution televisee, un responsable a presente sa lecture de la situation et appele a la vigilance. Les observateurs s''attendent a des mesures concretes sur le plan diplomatique et securitaire. Sur les reseaux sociaux, la prise de parole suscite des reactions contrastees.',
        '/assets/images/image11.webp',
        NOW() - interval '12 days',
        'Equipe Monde',
        'publie',
        1277,
        'Message officiel et reactions du public',
        'Une allocution televisee suscite des reactions contrastees.'
    ),
    (
        (SELECT id FROM categories WHERE libelle = 'Societe' LIMIT 1),
        'Ruines et reconstruction: les habitants face aux degats',
        'Un batiment lourdement endommage illustre l''ampleur des degats dans une zone residentielle. Les riverains evoquent des pertes materielles importantes et des deplacements temporaires. Les autorites locales annoncent un plan d''evaluation et une assistance pour les familles concernees.',
        '/assets/images/accueil.jpg',
        NOW() - interval '13 days',
        'Redaction',
        'publie',
        903,
        'Degats et reconstruction dans une zone residentielle',
        'Les habitants font face aux consequences materielles apres un incident majeur.'
    );

COMMIT;
