-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 03 nov. 2024 à 14:50
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
  `title_article` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content_article` varchar(800) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `picture_article` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `id` int DEFAULT NULL,
  `date_article` date DEFAULT NULL,
  PRIMARY KEY (`id_article`),
  KEY `foreign` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id_article`, `title_article`, `content_article`, `picture_article`, `id`, `date_article`) VALUES
(9, 'Les bienfaits du sport en pleine nature : un boost pour le corps et l\'esprit', '\r\nLe sport en pleine nature offre de nombreux bienfaits pour le corps et l\'esprit. Pratiquer une activité physique en extérieur, que ce soit la course à pied, le vélo, la randonnée ou le yoga, permet de se connecter à la nature et de respirer de l’air frais. Les paysages variés stimulent nos sens et apportent un sentiment de liberté et de tranquillité, réduisant le stress et l’anxiété.\r\n\r\nSur le plan physique, le terrain naturel renforce notre équilibre et sollicite davantage nos muscles que les surfaces artificielles. La lumière naturelle stimule la production de vitamine D, essentielle pour nos os et notre système immunitaire. De plus, l’effort en plein air améliore l’endurance, la force et la souplesse.', 'sport-nature-drome-960x640.jpeg', 21, '2024-11-03'),
(10, 'L\'Émerveillement de l\'Espace : Une Invitation à l\'Exploration', 'L’espace, vaste et mystérieux, fascine l’humanité depuis des millénaires. Observer les étoiles, imaginer des galaxies lointaines et des mondes inconnus réveille notre curiosité et notre désir d’exploration. Grâce aux avancées technologiques, nous avons envoyé des sondes, des robots et même des astronautes pour explorer des lieux comme la Lune, Mars et les confins de notre système solaire.\r\n\r\nCes explorations ont permis des découvertes incroyables, révélant des paysages inattendus et des phénomènes cosmiques fascinants. L’espace est aussi un rappel de la fragilité de notre planète, incitant à réfléchir sur notre place dans l’univers. En contemplant les étoiles, nous redécouvrons le pouvoir de rêver, de nous poser des questions et de poursuivre cette quête infinie de connaissances.', 'espace.jpg', 22, '2024-11-03');

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
(9, 1),
(9, 3),
(10, 2);

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id_cat` int NOT NULL AUTO_INCREMENT,
  `name_cat` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id_cat`, `name_cat`) VALUES
(1, 'Sport'),
(2, 'Espace'),
(3, 'Nature');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id_comment` int NOT NULL AUTO_INCREMENT,
  `content_comment` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_article` int DEFAULT NULL,
  `id` int DEFAULT NULL,
  `date_comment` date NOT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `foreign` (`id_article`),
  KEY `foreign2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id_comment`, `content_comment`, `id_article`, `id`, `date_comment`) VALUES
(34, 'Super article ! ', 9, 22, '2024-11-03');

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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `mdp`, `pseudo`, `admin`) VALUES
(21, 'test@test.fr', '$2y$10$SntMjVppq/F2.INAM6r02OVfpQWUrcTB1J3VCLGMD1jbTDNThx9h2', 'test', 0),
(22, 'admin@localhost.fr', '$2y$10$zs6JPPfFoEs..Ir6yKuh7OWCj6smfb.L2n5KuWActjq1V37IKXAYS', 'admin', 1);

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
