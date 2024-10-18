-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 18 oct. 2024 à 08:31
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
  `picture_article` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `id` int DEFAULT NULL,
  `date_article` date DEFAULT NULL,
  PRIMARY KEY (`id_article`),
  KEY `foreign` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `title_article`, `content_article`, `picture_article`, `id`, `date_article`) VALUES
(4, 'La retraite d\'une légende', 'Rafael Nadal, légende du tennis et détenteur de 22 titres du Grand Chelem, a annoncé sa retraite après près de deux décennies de carrière exceptionnelle. Connu pour sa combativité inébranlable et son esprit de guerrier, Nadal a marqué l\'histoire du tennis avec ses victoires emblématiques, notamment ses 14 titres à Roland-Garros, où il est devenu une véritable icône. À 38 ans, il laisse derrière lui un héritage inégalé, une popularité immense et le respect de millions de fans à travers le monde. Sa retraite marque la fin d\'une ère pour le tennis, mais son impact sur le sport et son style unique continueront d\'inspirer les générations futures. Merci, Rafa, pour ces moments mémorables et pour avoir élevé le tennis à de nouveaux sommets !\r\n\r\n', 'nadal.webp', 21, '2024-10-15');

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

--
-- Déchargement des données de la table `article_category_link`
--

INSERT INTO `article_category_link` (`id_article`, `id_cat`) VALUES
(4, 1),
(4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id_cat` int NOT NULL AUTO_INCREMENT,
  `name_cat` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id_cat`, `name_cat`) VALUES
(1, 'Sport');

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
  `date_comment` date NOT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `foreign` (`id_article`),
  KEY `foreign2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id_comment`, `content_comment`, `id_article`, `id`, `date_comment`) VALUES
(1, 'J\'adore ce joueur !', 4, 21, '2024-10-15'),
(3, 'Super !', 4, 23, '2024-10-16');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `mdp` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `pseudo` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `mdp`, `pseudo`, `admin`) VALUES
(21, 'test@test.fr', '$2y$10$SntMjVppq/F2.INAM6r02OVfpQWUrcTB1J3VCLGMD1jbTDNThx9h2', 'test', 0),
(22, 'admin@localhost.fr', '$2y$10$zs6JPPfFoEs..Ir6yKuh7OWCj6smfb.L2n5KuWActjq1V37IKXAYS', 'admin', 0),
(23, 'sacha.roux38@gmail.com', '$2y$10$zMoYW7gDxsQqgnJe7KzQvuMxFku4mgp7.qkADCj1.pwp9G.XUfZ6S', 'sacha', 0),
(27, 'dezded@ded.de', '$2y$10$CkiWdi/3C/bgmVncC4Cak..eSfXGUm6yvzdISbb3v0l4r8aGl47Y6', 'frfrf', 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `id_article` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
