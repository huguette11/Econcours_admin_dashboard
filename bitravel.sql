DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `email` varchar (50) NOT NULL,
   PRIMARY KEY (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Ajouter la colonne id_client si elle n’existe pas
ALTER TABLE historique_action
ADD COLUMN id_client INT NULL AFTER id_utilisateur;

-- Ajouter la contrainte de clé étrangère sur client(id_client)
ALTER TABLE historique_action
ADD CONSTRAINT fk_hist_client FOREIGN KEY (id_client) REFERENCES client(id_client);

CREATE TABLE IF NOT EXISTS `gare` (
  `id_gare` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `email` varchar (50) NOT NULL,
   PRIMARY KEY (`id_gare`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS `chauffeur` (
  `id_chauffeur` int NOT NULL AUTO_INCREMENT,
  `id_gare` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `telephone` varchar(15) NOT NULL,
  `permis` varchar (50) NOT NULL,
   PRIMARY KEY (`id_chauffeur`),
   FOREIGN KEY (`id_gare`) REFERENCES `gare`(`id_gare`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `car` (
  `id_car` int NOT NULL AUTO_INCREMENT,
  `id_gare` int NOT NULL,
  `immatriculation` varchar(50) NOT NULL,
  `capacite` int NOT NULL,
  `modele` varchar(50) NOT NULL,
  `etat` varchar(15) NOT NULL,
   PRIMARY KEY (`id_car`),
   FOREIGN KEY (`id_gare`) REFERENCES `gare`(`id_gare`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE IF NOT EXISTS `trajet` (
  `id_trajet` int NOT NULL AUTO_INCREMENT,
  `id_gare` int NOT NULL,
  `ville_depart` varchar(50) NOT NULL,
  `ville_arrivee` varchar(50) NOT NULL,
  `distance` float NOT NULL,
  `heure_depart` time NOT NULL,
  `heure_arrivee` time NOT NULL,
  `prix` int NOT NULL,
   PRIMARY KEY (`id_trajet`),
   FOREIGN KEY (`id_gare`) REFERENCES `gare`(`id_gare`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `voyage` (
  `id_voyage` int NOT NULL AUTO_INCREMENT,
  `id_trajet` int NOT NULL,
  `id_car` int NOT NULL,
  `id_chauffeur` int NOT NULL,
  `date_depart` date NOT NULL,
  `heure_depart` time NOT NULL,
  `statut` varchar (50) NOT NULL,
  `commentaire` varchar (50) NOT NULL,
   PRIMARY KEY (`id_voyage`),
   FOREIGN KEY (`id_trajet`) REFERENCES `trajet`(`id_trajet`),
   FOREIGN KEY (`id_car`) REFERENCES `car`(`id_car`),
   FOREIGN KEY (`id_chauffeur`) REFERENCES `chauffeur`(`id_chauffeur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `reservation` (
  `id_reservation` int NOT NULL AUTO_INCREMENT,
  `id_client` int NOT NULL,
  `id_trajet` int NOT NULL,
  `date_reservation` date NOT NULL,
  `statut` varchar (50) NOT NULL,
  `montant` varchar (50) NOT NULL,
  `mode_paiement` varchar (50) NOT NULL,
  `date_paiement` date NOT NULL,
   PRIMARY KEY (`id_reservation`),
   FOREIGN KEY (`id_trajet`) REFERENCES `trajet`(`id_trajet`),
   FOREIGN KEY (`id_client`) REFERENCES `client`(`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `colis` (
    `id_colis` INT AUTO_INCREMENT PRIMARY KEY,
    `id_client` INT NOT NULL,
    `id_voyage` INT NOT NULL,
    `reference` VARCHAR(50) NOT NULL UNIQUE,
    `contenu` TEXT NOT NULL,
    `poids` DECIMAL(8,2) NOT NULL,
    `destinataire` VARCHAR(100) NOT NULL,
    `tel_destinataire` VARCHAR(20) NOT NULL,
    `frais_expedition` INT NOT NULL,
    `statut` ENUM('Enregistré','En transit','Livré') DEFAULT 'Enregistré',
    FOREIGN KEY (`id_client`) REFERENCES `client`(`id_client`),
    FOREIGN KEY (`id_voyage`) REFERENCES `voyage`(`id_voyage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
