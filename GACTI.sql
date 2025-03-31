-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : dim. 30 mars 2025 à 10:29
-- Version du serveur : 9.2.0
-- Version de PHP : 8.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `GACTI`
--

-- --------------------------------------------------------

--
-- Structure de la table `ACTIVITE`
--

CREATE TABLE `ACTIVITE` (
  `CODEANIM` char(8) NOT NULL,
  `DATEACT` date NOT NULL,
  `CODEETATACT` char(2) NOT NULL,
  `HRRDVACT` time DEFAULT NULL,
  `PRIXACT` decimal(7,2) DEFAULT NULL,
  `HRDEBUTACT` time DEFAULT NULL,
  `HRFINACT` time DEFAULT NULL,
  `DATEANNULEACT` date DEFAULT NULL,
  `NOMRESP` char(40) DEFAULT NULL,
  `PRENOMRESP` char(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ACTIVITE`
--

INSERT INTO `ACTIVITE` (`CODEANIM`, `DATEACT`, `CODEETATACT`, `HRRDVACT`, `PRIXACT`, `HRDEBUTACT`, `HRFINACT`, `DATEANNULEACT`, `NOMRESP`, `PRENOMRESP`) VALUES
('ANIM001', '2024-11-24', 'ou', '08:00:00', 15.00, '09:00:00', '17:00:00', NULL, 'Dupont', 'Jean'),
('ANIM001', '2025-01-10', 'ou', '08:00:00', 20.00, '09:00:00', '17:00:00', NULL, 'yy', 'yy'),
('ANIM001', '2025-01-17', 'an', '09:00:00', 59.00, '09:30:00', '13:00:00', NULL, NULL, NULL),
('ANIM001', '2025-05-15', 'ou', '08:30:00', 20.00, '09:00:00', '17:00:00', NULL, 'yy', 'yy'),
('ANIM002', '2024-11-18', 'ou', '10:00:00', 50.00, '11:00:00', '15:00:00', NULL, 'Martin', 'Claire'),
('ANIM002', '2024-11-25', 'ou', '10:00:00', 50.00, '11:00:00', '15:00:00', NULL, 'Martin', 'Claire'),
('ANIM002', '2025-01-12', 'ou', '10:00:00', 60.00, '11:00:00', '15:30:00', NULL, NULL, NULL),
('ANIM002', '2025-05-20', 'ou', '11:00:00', 70.00, '11:30:00', '15:30:00', NULL, 'yy', 'yy'),
('ANIM003', '2024-10-26', 'ou', '14:00:00', 5.00, '14:30:00', '17:30:00', NULL, 'Leroy', 'Marie'),
('ANIM003', '2024-11-19', 'ou', '14:00:00', 5.00, '14:30:00', '17:30:00', NULL, 'Leroy', 'Marie'),
('ANIM003', '2025-01-15', 'ou', '14:00:00', 10.00, '14:30:00', '17:00:00', NULL, 'yy', 'yy'),
('ANIM003', '2025-05-25', 'ou', '14:00:00', 15.00, '14:30:00', '18:00:00', NULL, 'yy', 'yy'),
('ANIM004', '2024-11-06', 'ou', '10:00:00', 35.90, '10:10:00', '13:15:00', NULL, 'yy', 'yy'),
('ANIM004', '2024-11-20', 'ou', '09:00:00', 30.00, '10:00:00', '16:00:00', NULL, 'Durand', 'Pierre'),
('ANIM004', '2025-01-20', 'ou', '09:30:00', 35.00, '10:00:00', '16:30:00', NULL, 'yy', 'yy'),
('ANIM004', '2025-05-30', 'ou', '10:00:00', 40.00, '10:30:00', '16:00:00', NULL, NULL, NULL),
('ANIM005', '2024-11-21', 'ou', '08:00:00', 3.00, '09:00:00', '11:00:00', '2024-11-05', NULL, NULL),
('ANIM005', '2024-11-24', 'ou', '09:00:00', 35.00, '10:00:00', '18:00:00', NULL, NULL, NULL),
('ANIM005', '2025-01-25', 'ou', '08:30:00', 15.00, '09:00:00', '11:30:00', NULL, NULL, NULL),
('ANIM005', '2025-03-28', 'in', '10:00:00', 12.00, '11:00:00', '18:00:00', '2025-03-23', NULL, NULL),
('ANIM005', '2025-05-31', 'ou', '08:00:00', 10.00, '08:30:00', '11:00:00', NULL, NULL, NULL),
('ANIM006', '2024-11-15', 'ou', '08:00:00', 15.76, '08:30:00', '16:00:00', NULL, NULL, NULL),
('ANIM006', '2024-11-17', 'ou', '08:00:00', 15.76, '08:30:00', '16:00:00', '2024-11-05', NULL, NULL),
('ANIM006', '2024-11-18', 'ou', '09:00:00', 75.78, '10:00:00', '18:00:00', NULL, NULL, NULL),
('ANIM006', '2025-01-19', 'ou', '14:00:00', 15.00, '14:30:00', '17:00:00', NULL, NULL, NULL),
('ANIM006', '2025-05-05', 'ou', '09:00:00', 25.00, '09:30:00', '13:00:00', NULL, 'yy', 'yy'),
('ANIM006', '2025-05-15', 'ou', '09:30:00', 30.00, '10:00:00', '12:30:00', NULL, 'yy', 'yy'),
('ANIM007', '2025-02-18', 'ou', '14:00:00', 45.00, '15:00:00', '17:00:00', '2025-01-07', NULL, NULL),
('ANIM007', '2025-05-10', 'an', '15:00:00', 50.00, '15:30:00', '18:30:00', '2025-03-24', NULL, NULL),
('ANIM007', '2025-05-18', 'ou', '14:00:00', 55.00, '14:30:00', '17:30:00', NULL, NULL, NULL),
('ANIM007', '2025-05-20', 'in', '10:00:00', 32.00, '10:30:00', '12:30:00', NULL, NULL, NULL),
('ANIM008', '2025-01-20', 'ou', '10:00:00', 130.00, '10:15:00', '13:30:00', '2025-01-12', 'yy', 'yy'),
('ANIM008', '2025-05-12', 'ou', '10:00:00', 100.00, '10:15:00', '13:45:00', NULL, NULL, NULL);

--
-- Déclencheurs `ACTIVITE`
--
DELIMITER $$
CREATE TRIGGER `before_activite_update` BEFORE UPDATE ON `ACTIVITE` FOR EACH ROW BEGIN
    IF (OLD.DATEANNULEACT IS NULL AND NEW.DATEANNULEACT IS NOT NULL) THEN
        SET NEW.CODEETATACT = 'an';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `ANIMATION`
--

CREATE TABLE `ANIMATION` (
  `CODEANIM` char(8) NOT NULL,
  `CODETYPEANIM` char(5) NOT NULL,
  `NOMANIM` char(40) DEFAULT NULL,
  `DATECREATIONANIM` date DEFAULT NULL,
  `DATEVALIDITEANIM` date DEFAULT NULL,
  `DUREEANIM` double(5,0) DEFAULT NULL,
  `LIMITEAGE` int DEFAULT NULL,
  `TARIFANIM` decimal(7,2) DEFAULT NULL,
  `NBREPLACEANIM` int DEFAULT NULL,
  `DESCRIPTANIM` char(250) DEFAULT NULL,
  `COMMENTANIM` char(250) DEFAULT NULL,
  `DIFFICULTEANIM` char(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ANIMATION`
--

INSERT INTO `ANIMATION` (`CODEANIM`, `CODETYPEANIM`, `NOMANIM`, `DATECREATIONANIM`, `DATEVALIDITEANIM`, `DUREEANIM`, `LIMITEAGE`, `TARIFANIM`, `NBREPLACEANIM`, `DESCRIPTANIM`, `COMMENTANIM`, `DIFFICULTEANIM`) VALUES
('ANIM001', 'pedes', 'Randonnée au Glacier Blanc', '2024-01-01', '2024-12-31', 8, 12, 15.00, 20, 'Randonnée pédestre au refuge du Glacier Blanc à Ailefroide.', 'Prévoir de bonnes chaussures', 'Moyenne'),
('ANIM002', 'rivie', 'Rafting sur la Durance', '2024-01-01', '2024-12-31', 4, 16, 50.00, 1, 'Descente en rafting de la Durance à partir de Briançon.', 'Activité encadrée par un professionnel', 'Difficile'),
('ANIM003', 'flore', 'Observation de la flore', '2024-01-01', '2024-12-31', 3, 10, 5.00, 15, 'Sortie d\'études de la flore environnante.', 'Apporter un carnet pour prendre des notes', 'Facile'),
('ANIM004', 'escal', 'Escalade en falaise', '2024-01-01', '2024-12-31', 4, 14, 30.00, 12, 'Initiation à l\'escalade sur les falaises locales.', 'Équipement fourni', 'Difficile'),
('ANIM005', 'forme', 'Cours de remise en forme', '2024-01-01', '2024-12-31', 1, 18, 10.00, 25, 'Séance de remise en forme en plein air.', 'Prévoir une serviette et de l\'eau', 'Facile'),
('ANIM006', 'pisci', 'Cours de natation', NULL, NULL, 1, 6, 5.00, 50, 'Venez apprendre à nager ou à perfectionner votre nage !', '.', 'Facile'),
('ANIM007', 'rivie', 'Canoë sur le Verdon', '2025-01-07', NULL, 3, 12, 43.00, 14, 'Canoë sur le Verdon', 'Petite balade sur le Verdon avec quelques rapides', 'Moyen'),
('ANIM008', 'para', 'Escapade en parapente', '2025-01-12', NULL, 4, 18, 160.00, 15, 'Venez voler avec les oiseaux et vous sentir libre comme l\'air.', 'Mettez une tenu de sport qui ne craint rien', 'Moyen');

-- --------------------------------------------------------

--
-- Structure de la table `COMPTE`
--

CREATE TABLE `COMPTE` (
  `USER` char(8) NOT NULL,
  `MDP` char(10) DEFAULT NULL,
  `NOMCOMPTE` char(40) DEFAULT NULL,
  `PRENOMCOMPTE` char(30) DEFAULT NULL,
  `DATEINSCRIP` date DEFAULT NULL,
  `DATEFERME` date DEFAULT NULL,
  `TYPEPROFIL` char(2) DEFAULT NULL,
  `DATEDEBSEJOUR` date DEFAULT NULL,
  `DATEFINSEJOUR` date DEFAULT NULL,
  `DATENAISCOMPTE` date DEFAULT NULL,
  `ADRMAILCOMPTE` char(70) DEFAULT NULL,
  `NOTELCOMPTE` char(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `COMPTE`
--

INSERT INTO `COMPTE` (`USER`, `MDP`, `NOMCOMPTE`, `PRENOMCOMPTE`, `DATEINSCRIP`, `DATEFERME`, `TYPEPROFIL`, `DATEDEBSEJOUR`, `DATEFINSEJOUR`, `DATENAISCOMPTE`, `ADRMAILCOMPTE`, `NOTELCOMPTE`) VALUES
('aa', 'aa', NULL, NULL, NULL, NULL, 'va', NULL, NULL, NULL, NULL, NULL),
('admin', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('tt', 'tt', 'tt', 'tt', NULL, NULL, 'va', '2025-01-05', '2025-06-30', '2011-01-05', NULL, NULL),
('yy', 'yy', 'yy', 'yy', NULL, NULL, 'en', NULL, NULL, '2001-03-07', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ETAT_ACT`
--

CREATE TABLE `ETAT_ACT` (
  `CODEETATACT` char(2) NOT NULL,
  `NOMETATACT` char(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ETAT_ACT`
--

INSERT INTO `ETAT_ACT` (`CODEETATACT`, `NOMETATACT`) VALUES
('an', 'Inscription impossible'),
('in', 'Inscription incertaine'),
('ou', 'Inscription possible');

-- --------------------------------------------------------

--
-- Structure de la table `INSCRIPTION`
--

CREATE TABLE `INSCRIPTION` (
  `NOINSCRIP` bigint NOT NULL,
  `USER` char(8) NOT NULL,
  `CODEANIM` char(8) NOT NULL,
  `DATEACT` date NOT NULL,
  `DATEINSCRIP` date DEFAULT NULL,
  `DATEANNULE` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `INSCRIPTION`
--

INSERT INTO `INSCRIPTION` (`NOINSCRIP`, `USER`, `CODEANIM`, `DATEACT`, `DATEINSCRIP`, `DATEANNULE`) VALUES
(11, 'yy', 'ANIM001', '2024-11-24', '2024-10-15', NULL),
(12, 'yy', 'ANIM002', '2024-11-18', '2024-10-23', NULL),
(13, 'yy', 'ANIM004', '2024-11-20', '2024-10-23', NULL),
(14, 'tt', 'ANIM001', '2024-11-24', '2025-01-07', '2025-01-07'),
(15, 'tt', 'ANIM006', '2025-01-19', '2025-01-12', '2025-01-12'),
(16, 'tt', 'ANIM006', '2025-01-19', '2025-01-12', '2025-01-12'),
(17, 'yy', 'ANIM006', '2025-01-19', '2025-01-12', NULL),
(18, 'tt', 'ANIM001', '2025-05-15', '2025-01-13', NULL),
(19, 'tt', 'ANIM002', '2025-05-20', '2025-01-13', NULL),
(20, 'yy', 'ANIM002', '2025-05-20', '2025-01-13', '2025-01-13'),
(21, 'yy', 'ANIM006', '2025-05-15', '2025-01-13', '2025-01-13'),
(22, 'yy', 'ANIM004', '2025-05-30', '2025-01-13', NULL),
(23, 'yy', 'ANIM003', '2025-05-25', '2025-01-13', NULL),
(24, 'tt', 'ANIM004', '2025-05-30', '2025-01-13', '2025-03-23'),
(25, 'tt', 'ANIM003', '2025-05-25', '2025-01-14', '2025-01-14'),
(26, 'tt', 'ANIM003', '2025-05-25', '2025-01-14', '2025-01-14'),
(27, 'tt', 'ANIM003', '2025-05-25', '2025-01-14', '2025-01-14'),
(28, 'tt', 'ANIM005', '2025-01-25', '2025-01-14', NULL),
(29, 'tt', 'ANIM007', '2025-05-10', '2025-03-24', '2025-03-24'),
(30, 'tt', 'ANIM006', '2025-05-05', '2025-03-24', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `TYPE_ANIM`
--

CREATE TABLE `TYPE_ANIM` (
  `CODETYPEANIM` char(5) NOT NULL,
  `NOMTYPEANIM` char(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `TYPE_ANIM`
--

INSERT INTO `TYPE_ANIM` (`CODETYPEANIM`, `NOMTYPEANIM`) VALUES
('escal', 'Escalade'),
('flore', 'Sortie d\'études de la flore'),
('forme', 'Cours de remise en forme'),
('para', 'Parapente'),
('pedes', 'Sortie pédestre'),
('pisci', 'Piscine'),
('rivie', 'Descente de rivière');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ACTIVITE`
--
ALTER TABLE `ACTIVITE`
  ADD PRIMARY KEY (`CODEANIM`,`DATEACT`),
  ADD KEY `I_FK_ACTIVITE_ANIMATION` (`CODEANIM`),
  ADD KEY `I_FK_ACTIVITE_ETAT_ACT` (`CODEETATACT`);

--
-- Index pour la table `ANIMATION`
--
ALTER TABLE `ANIMATION`
  ADD PRIMARY KEY (`CODEANIM`),
  ADD KEY `I_FK_ANIMATION_TYPE_ANIM` (`CODETYPEANIM`);

--
-- Index pour la table `COMPTE`
--
ALTER TABLE `COMPTE`
  ADD PRIMARY KEY (`USER`);

--
-- Index pour la table `ETAT_ACT`
--
ALTER TABLE `ETAT_ACT`
  ADD PRIMARY KEY (`CODEETATACT`);

--
-- Index pour la table `INSCRIPTION`
--
ALTER TABLE `INSCRIPTION`
  ADD PRIMARY KEY (`NOINSCRIP`),
  ADD KEY `I_FK_INSCRIPTION_COMPTE` (`USER`),
  ADD KEY `I_FK_INSCRIPTION_ACTIVITE` (`CODEANIM`,`DATEACT`);

--
-- Index pour la table `TYPE_ANIM`
--
ALTER TABLE `TYPE_ANIM`
  ADD PRIMARY KEY (`CODETYPEANIM`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `INSCRIPTION`
--
ALTER TABLE `INSCRIPTION`
  MODIFY `NOINSCRIP` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ACTIVITE`
--
ALTER TABLE `ACTIVITE`
  ADD CONSTRAINT `activite_ibfk_1` FOREIGN KEY (`CODEANIM`) REFERENCES `ANIMATION` (`CODEANIM`),
  ADD CONSTRAINT `activite_ibfk_2` FOREIGN KEY (`CODEETATACT`) REFERENCES `ETAT_ACT` (`CODEETATACT`);

--
-- Contraintes pour la table `ANIMATION`
--
ALTER TABLE `ANIMATION`
  ADD CONSTRAINT `animation_ibfk_1` FOREIGN KEY (`CODETYPEANIM`) REFERENCES `TYPE_ANIM` (`CODETYPEANIM`);

--
-- Contraintes pour la table `INSCRIPTION`
--
ALTER TABLE `INSCRIPTION`
  ADD CONSTRAINT `inscription_ibfk_1` FOREIGN KEY (`USER`) REFERENCES `COMPTE` (`USER`),
  ADD CONSTRAINT `inscription_ibfk_2` FOREIGN KEY (`CODEANIM`,`DATEACT`) REFERENCES `ACTIVITE` (`CODEANIM`, `DATEACT`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
