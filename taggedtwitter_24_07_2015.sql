-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 24 Juillet 2015 à 12:08
-- Version du serveur :  5.6.24
-- Version de PHP :  5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `taggedtwitter`
--
CREATE DATABASE IF NOT EXISTS `taggedtwitter` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `taggedtwitter`;

-- --------------------------------------------------------

--
-- Structure de la table `tag_id`
--

CREATE TABLE IF NOT EXISTS `tag_id` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `tweet_id`
--

CREATE TABLE IF NOT EXISTS `tweet_id` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `messages` varchar(140) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `token` varchar(32) NOT NULL,
  `tweet` int(11) NOT NULL,
  `tagg` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `token`, `tweet`, `tagg`, `date_created`, `date_modified`) VALUES
(2, 'Bla', 'blablabla@gmail.com', '$2y$10$mUIeO0ioxQAb/x4NmPnma.GX57YbYD5lbcfD8rwpGkaqMECBK19ra', '', 0, 0, '2015-07-23 15:10:10', '2015-07-23 15:10:10'),
(3, 'Tony', 'seper@gmail.com', '$2y$10$tUOV7GyjO0Mr9406jLVpDOqbqz4yOmO3XTKGZoteaMD3sM0FQeH3O', '', 0, 0, '2015-07-23 15:31:44', '2015-07-23 15:31:44');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `tag_id`
--
ALTER TABLE `tag_id`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tweet_id`
--
ALTER TABLE `tweet_id`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `tag_id`
--
ALTER TABLE `tag_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `tweet_id`
--
ALTER TABLE `tweet_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
