-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 15 oct. 2024 à 06:12
-- Version du serveur : 8.0.28
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog_s2`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id_article` int NOT NULL AUTO_INCREMENT,
  `title_article` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `content_article` varchar(2000) COLLATE utf8mb4_general_ci NOT NULL,
  `picture_article` mediumblob NOT NULL,
  `id` int DEFAULT NULL,
  PRIMARY KEY (`id_article`),
  KEY `foreign` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `article_category_link`
--

DROP TABLE IF EXISTS `article_category_link`;
CREATE TABLE IF NOT EXISTS `article_category_link` (
  `id_article` int NOT NULL,
  `id_cat` int NOT NULL,
  KEY `foreign` (`id_article`),
  KEY `foreign2` (`id_cat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id_cat` int NOT NULL AUTO_INCREMENT,
  `name_cat` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id_comment` int NOT NULL AUTO_INCREMENT,
  `content_comment` varchar(2000) COLLATE utf8mb4_general_ci NOT NULL,
  `id_article` int DEFAULT NULL,
  `id` int DEFAULT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `foreign` (`id_article`),
  KEY `foreign2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `mdp` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `pseudo` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `mdp`, `pseudo`, `admin`) VALUES
(1, 'admin@localhost.fr', 'admin69IUT', 'admin', 1);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `id_article` FOREIGN KEY (`id`) REFERENCES `article` (`id_article`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `article_category_link`
--
ALTER TABLE `article_category_link`
  ADD CONSTRAINT `id_article_article_cat` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_cat_article_cat` FOREIGN KEY (`id_cat`) REFERENCES `category` (`id_cat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `id_article_foreign` FOREIGN KEY (`id_article`) REFERENCES `article` (`id_article`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `id_foreign` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
