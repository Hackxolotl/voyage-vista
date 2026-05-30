DROP TABLE IF EXISTS packages;
DROP TABLE IF EXISTS utilisateurs;

CREATE TABLE packages (
    id_packages INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    img_url VARCHAR(50),
    region VARCHAR(50),
    country VARCHAR(50),
    price DECIMAL(10, 2) NOT NULL,
    descriptions TEXT,
    duration INT,
    nbNuits INT,
    rating DECIMAL(3,1),
    reviews INT,
    participants INT
);

CREATE TABLE utilisateurs (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,

    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,

    role ENUM(
        'user',
        'prestataire',
        'admin'
    ) DEFAULT 'user',

    est_etudiant BOOLEAN DEFAULT FALSE,

    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO packages (nom, img_url, region, country, price, descriptions, duration, nbNuits, rating, reviews, participants) VALUES
("Barcelone Beach Break", "Barcelone", "Europe", "Espagne", 140, "4 jours à Barcelone avec plages méditerranéennes et architecture gothique. Profitez d'une ville vibrante mêlant culture, gastronomie et farniente sur la plage.", 4, 3, 4.8, 245, 3),
("Rome Express","Rome", "Europe", "Italie", 179, "4 jours à Rome pour découvrir l'histoire antique et la gastronomie italienne. Colisée, Vatican, gelato... un séjour inoubliable.", 4, 3, 4.9, 312, 4),
("Paris Romantique", "Paris", "Europe", "France", 80,  "Week-end magique à Paris, visite de la Tour Eiffel et musées renommés. La ville lumière vous attend.", 3, 2, 4.7, 198, 5),
("Alpes Adventure", "Alpes", "Europe", "France", 275, "6 jours d'action dans les Alpes : ski, randonnée et paysages montagneux spectaculaires.", 6, 5, 4.6, 156, 6),
("Bali Paradise", "Bali", "Asie", "Indonésie", 870, "8 jours de détente à Bali : plages de sable blanc, temples sacrés et spa de luxe.", 8,7,4.9,423,6),
("Safari Kenya Budget", "Kenya", "Afrique", "Kenya", 725, "8 jours de safari au Kenya : découverte de la savane, animaux sauvages et immersion africaine à prix étudiant.", 8, 7, 4.6, 89, 3),
("New York City", "New-york", "Amérique", "États-Unis", 640, "5 jours dans la ville qui ne dort jamais : Broadway, Times Square et musées world-class.", 5, 4, 4.7, 267, 4),
("Tokyo Experience", "Tokyo", "Asie", "Japon", 890, "7 jours à Tokyo : tradition et technologie se mêlent dans une ville fascinante.", 7, 6, 4.8, 178, 5),
("Seoul Dream", "Seoul", "Asie", "Corée du Sud", 540, "7 jours à Séoul : palais royaux, K-pop, gastronomie coréenne et quartiers branchés.", 7, 6, 5.0, 200, 2),
("Sydney Escape", "Sydney", "Océanie", "Australie", 674, "8 jours à Sydney : Opéra, plages et culture australienne pour un séjour inoubliable.", 8, 7, 5, 175, 4);
