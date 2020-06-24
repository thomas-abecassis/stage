-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  mer. 24 juin 2020 à 09:46
-- Version du serveur :  5.5.47-0+deb8u1
-- Version de PHP :  7.2.22-1+0~20190902.26+debian8~1.gbpd64eb7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `abecassist`
--

-- --------------------------------------------------------

--
-- Structure de la table `alerte`
--

CREATE TABLE `alerte` (
  `loginUtilisateur` varchar(256) NOT NULL,
  `tabSimple` varchar(1028) NOT NULL,
  `tabCheckBox` varchar(1028) NOT NULL,
  `nom` varchar(256) NOT NULL,
  `idAlerte` int(11) NOT NULL,
  `activeMail` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `lot`
--

CREATE TABLE `lot` (
  `id` varchar(11) NOT NULL,
  `localisation` mediumint(8) UNSIGNED NOT NULL,
  `surface` int(11) NOT NULL,
  `loyer` int(11) NOT NULL,
  `description` varchar(2048) NOT NULL,
  `informationsCommercial` varchar(1028) NOT NULL,
  `typeDeBien` varchar(256) NOT NULL,
  `nombreDePieces` int(11) NOT NULL,
  `location` tinyint(1) NOT NULL DEFAULT '1',
  `mail` int(11) DEFAULT NULL,
  `telephone` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `lotCategorie`
--

CREATE TABLE `lotCategorie` (
  `idLot` varchar(11) NOT NULL,
  `idValeurCategorie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mailLot`
--

CREATE TABLE `mailLot` (
  `id` int(11) NOT NULL,
  `mail` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `optionsSite`
--

CREATE TABLE `optionsSite` (
  `nomOption` varchar(64) NOT NULL,
  `valeur` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `sousCategorie`
--

CREATE TABLE `sousCategorie` (
  `id` int(11) NOT NULL,
  `categorieId` int(11) NOT NULL,
  `valeur` varchar(256) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `telephoneLot`
--

CREATE TABLE `telephoneLot` (
  `id` int(11) NOT NULL,
  `telephone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `login` varchar(256) NOT NULL,
  `nom` varchar(32) NOT NULL,
  `prenom` varchar(32) NOT NULL,
  `mdp` varchar(64) NOT NULL,
  `role` smallint(2) NOT NULL DEFAULT '0',
  `dateDerniereConnexion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `villesFrance`
--

CREATE TABLE `villesFrance` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `codePostal` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `alerte`
--
ALTER TABLE `alerte`
  ADD PRIMARY KEY (`idAlerte`),
  ADD KEY `contrainteLogin` (`loginUtilisateur`);

--
-- Index pour la table `lot`
--
ALTER TABLE `lot`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contrainteLocalisation` (`localisation`),
  ADD KEY `contrainteTelephone` (`telephone`),
  ADD KEY `contrainteMail` (`mail`);

--
-- Index pour la table `lotCategorie`
--
ALTER TABLE `lotCategorie`
  ADD KEY `contraineIdLot` (`idLot`),
  ADD KEY `contrainteValeur` (`idValeurCategorie`);

--
-- Index pour la table `mailLot`
--
ALTER TABLE `mailLot`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sousCategorie`
--
ALTER TABLE `sousCategorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contrainteCategorieId` (`categorieId`);

--
-- Index pour la table `telephoneLot`
--
ALTER TABLE `telephoneLot`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`login`);

--
-- Index pour la table `villesFrance`
--
ALTER TABLE `villesFrance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ville_nom_reel` (`nom`),
  ADD KEY `ville_code_postal` (`codePostal`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `alerte`
--
ALTER TABLE `alerte`
  MODIFY `idAlerte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;

--
-- AUTO_INCREMENT pour la table `mailLot`
--
ALTER TABLE `mailLot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `sousCategorie`
--
ALTER TABLE `sousCategorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `telephoneLot`
--
ALTER TABLE `telephoneLot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `villesFrance`
--
ALTER TABLE `villesFrance`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36831;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `alerte`
--
ALTER TABLE `alerte`
  ADD CONSTRAINT `contrainteLogin` FOREIGN KEY (`loginUtilisateur`) REFERENCES `utilisateur` (`login`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `lot`
--
ALTER TABLE `lot`
  ADD CONSTRAINT `contrainteLocalisation` FOREIGN KEY (`localisation`) REFERENCES `villesFrance` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contrainteMail` FOREIGN KEY (`mail`) REFERENCES `mailLot` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contrainteTelephone` FOREIGN KEY (`telephone`) REFERENCES `telephoneLot` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `lotCategorie`
--
ALTER TABLE `lotCategorie`
  ADD CONSTRAINT `contrainteValeur` FOREIGN KEY (`idValeurCategorie`) REFERENCES `sousCategorie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `contraineIdLot` FOREIGN KEY (`idLot`) REFERENCES `lot` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sousCategorie`
--
ALTER TABLE `sousCategorie`
  ADD CONSTRAINT `contrainteCategorieId` FOREIGN KEY (`categorieId`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
