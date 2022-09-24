-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 24 sep. 2022 à 12:50
-- Version du serveur : 8.0.27
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--
CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `blog`;

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_880E0D76F85E0677` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` date NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=374 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `titre`, `contenu`, `date_creation`, `state`) VALUES
(371, 'LaPLateforme', 'Racontez votre vie', '2022-09-24', 'publier'),
(372, 'Khellaff', 'Vous en pensez quoi de Khellaff?????', '2022-09-24', 'publier'),
(373, 'Football', 'Le ballon d\'or est pour Kb9', '2022-09-24', 'publier');

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(49, 'Sport'),
(50, 'Tout'),
(51, 'Dev'),
(52, 'Femme'),
(53, 'Gossip La Plateforme'),
(54, 'BALANCE TOUT');

-- --------------------------------------------------------

--
-- Structure de la table `category_article`
--

DROP TABLE IF EXISTS `category_article`;
CREATE TABLE IF NOT EXISTS `category_article` (
  `category_id` int NOT NULL,
  `article_id` int NOT NULL,
  PRIMARY KEY (`category_id`,`article_id`),
  KEY `IDX_C5E24E1812469DE2` (`category_id`),
  KEY `IDX_C5E24E187294869C` (`article_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category_article`
--

INSERT INTO `category_article` (`category_id`, `article_id`) VALUES
(49, 373),
(50, 372),
(50, 373),
(51, 371),
(51, 372),
(53, 371),
(54, 371),
(54, 372);

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `article_id` int NOT NULL,
  `contenu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_comment` datetime NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526C7294869C` (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `article_id`, `contenu`, `date_comment`, `author`) VALUES
(164, 373, 'Ah si il ne l\'as pas, j\'arrête le foot', '2022-09-24 09:55:21', 'amine'),
(165, 372, 'Franchement je l\'aime bien mais il ronfle trop fort, donc c\'est chiant quoi', '2022-09-24 10:52:43', 'chaima');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220907012918', '2022-09-07 03:32:27', 298),
('DoctrineMigrations\\Version20220910022302', '2022-09-10 04:27:25', 627),
('DoctrineMigrations\\Version20220910044957', '2022-09-10 06:51:27', 261),
('DoctrineMigrations\\Version20220921183045', '2022-09-21 20:31:30', 256),
('DoctrineMigrations\\Version20220921224919', '2022-09-22 00:50:15', 258),
('DoctrineMigrations\\Version20220922155828', '2022-09-22 18:00:45', 245);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`) VALUES
(21, 'paul', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '$2y$13$DrLb1P.YRDgTe4SyiPoR4upYvENZclU9i4YzcyJA4DkheNfmKWPsu'),
(22, 'admin', '[\"ROLE_ADMIN\"]', '$2y$13$iaclZzFcWQeehLXphjlyoe2scDrPaBrFpfhcOWvOYZiek4XMdBeHS'),
(25, 'mohamad12', '[]', '$2y$13$Usr59oelpvhIxagxlySZA.qKxE6GU1VClgrkBfhcKaOierkGnkQ56'),
(26, 'test1', '[]', '$2y$13$bg.DuYuxB5V3hfGGTrq08ukHhImMzNsoh8YHQNouYBjiRwMquwqNO');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `category_article`
--
ALTER TABLE `category_article`
  ADD CONSTRAINT `FK_C5E24E1812469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_C5E24E187294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
