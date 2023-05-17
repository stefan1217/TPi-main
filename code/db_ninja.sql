-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 16 mai 2023 à 13:47
-- Version du serveur :  5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_ninja`
--

-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS `db_ninja` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_ninja`;

--
-- Structure de la table `game`
--

DROP TABLE IF EXISTS `game`;
CREATE TABLE IF NOT EXISTS `game` (
  `idGame` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_start` datetime NOT NULL,
  `date_last_update` datetime NOT NULL,
  `score` int(11) NOT NULL,
  `slice_count` int(11) NOT NULL,
  `duration` time NOT NULL,
  `idUser` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL,
  `category` varchar(50) NOT NULL,
  `parentIdUser` int(11) NOT NULL,
  PRIMARY KEY (`idGame`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=904 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `idItem` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `picture_path` varchar(50) NOT NULL,
  `category` enum('céréale','féculent','fruit','légume','légumineuse') NOT NULL,
  PRIMARY KEY (`idItem`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`idItem`, `name`, `picture_path`, `category`) VALUES
(1, 'Tofu', 'Tofu.png', 'légumineuse'),
(2, 'Petit Pois', 'Petits_Pois.png', 'légumineuse'),
(3, 'Maïs', 'Maïs.png', 'céréale'),
(4, 'Riz', 'Riz.png', 'céréale'),
(5, 'Baguette', 'Baguette.png', 'féculent'),
(6, 'Patates', 'Patates.png', 'féculent'),
(7, 'Pomme', 'pomme.png', 'fruit'),
(8, 'Poire', 'Poire.png', 'fruit'),
(9, 'Choux-fleurs', 'Choux-fleurs.png', 'légume'),
(10, 'Radis', 'Radis.png', 'légume');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) NOT NULL,
  `password` longtext NOT NULL,
  `registration_date` datetime NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `game_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- Création de l'utilisateur
CREATE USER IF NOT EXISTS 'slim_ninja_user'@'localhost' IDENTIFIED BY PASSWORD "*F3C8C27716DFA16408085940A941FE9E2CD62F28";
GRANT ALL PRIVILEGES ON db_ninja.* TO 'slim_ninja_user'@'%';