-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Dim 21 Mai 2023 à 22:53
-- Version du serveur :  5.7.29
-- Version de PHP :  5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `in21b10112`
--

-- --------------------------------------------------------

--
-- Structure de la table `Participer`
--

CREATE TABLE `Participer` (
                              `id_utilisateur` int(11) NOT NULL,
                              `id_tournoi` int(11) NOT NULL,
                              `dateInscription` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Participer`
--

INSERT INTO `Participer` (`id_utilisateur`, `id_tournoi`, `dateInscription`) VALUES
                                                                                 (20, 1, '2023-05-18'),
                                                                                 (20, 2, '2023-04-09'),
                                                                                 (20, 3, '2023-04-09'),
                                                                                 (20, 4, '2023-03-18'),
                                                                                 (20, 5, '2023-04-02'),
                                                                                 (25, 1, '2023-04-06'),
                                                                                 (25, 2, '2023-04-04'),
                                                                                 (25, 3, '2023-04-01'),
                                                                                 (25, 4, '2023-03-29'),
                                                                                 (25, 5, '2023-04-05');

-- --------------------------------------------------------

--
-- Structure de la table `Rencontre`
--

CREATE TABLE `Rencontre` (
                             `id_rencontre` int(11) NOT NULL,
                             `id_tournoi` int(11) NOT NULL,
                             `id_joueurUn` int(11) DEFAULT NULL,
                             `id_joueurDeux` int(11) DEFAULT NULL,
                             `score_joueurUn` int(11) DEFAULT NULL,
                             `score_joueurDeux` int(11) DEFAULT NULL,
                             `id_vainqueur` int(11) DEFAULT NULL,
                             `id_rencontreSuivante` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Sport`
--

CREATE TABLE `Sport` (
                         `id_sport` int(11) NOT NULL,
                         `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Sport`
--

INSERT INTO `Sport` (`id_sport`, `nom`) VALUES
                                            (1, 'Echec'),
                                            (2, 'Belote'),
                                            (3, 'Fifa'),
                                            (4, 'Tennis'),
                                            (5, 'Ping-Pong');

-- --------------------------------------------------------

--
-- Structure de la table `Statut`
--

CREATE TABLE `Statut` (
                          `id_statut` int(11) NOT NULL,
                          `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Statut`
--

INSERT INTO `Statut` (`id_statut`, `nom`) VALUES
                                              (1, 'Ouvert'),
                                              (2, 'Fermé'),
                                              (3, 'Clôturé'),
                                              (4, 'Généré'),
                                              (5, 'En-cours'),
                                              (6, 'Terminé');

-- --------------------------------------------------------

--
-- Structure de la table `Tournoi`
--

CREATE TABLE `Tournoi` (
                           `id_tournoi` int(11) NOT NULL,
                           `nom` varchar(100) NOT NULL,
                           `id_sport` int(11) NOT NULL,
                           `placesDisponnibles` int(11) NOT NULL,
                           `statut` int(11) NOT NULL,
                           `dateTournoi` date NOT NULL,
                           `dateFinInscription` date NOT NULL,
                           `estActif` tinyint(1) NOT NULL,
                           `id_organisateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Tournoi`
--

INSERT INTO `Tournoi` (`id_tournoi`, `nom`, `id_sport`, `placesDisponnibles`, `statut`, `dateTournoi`, `dateFinInscription`, `estActif`, `id_organisateur`) VALUES
                                                                                                                                                                (1, 'Master Tournament', 1, 2, 1, '2023-08-19', '2023-06-28', 1, 25),
                                                                                                                                                                (2, 'Tournoi de belote', 2, 28, 1, '2023-09-11', '2023-08-25', 1, 25),
                                                                                                                                                                (3, 'FIFA Series', 3, 26, 1, '2023-11-21', '2023-10-10', 1, 25),
                                                                                                                                                                (4, 'Grand Chelem', 4, 18, 1, '2024-01-01', '2023-12-13', 1, 25),
                                                                                                                                                                (5, 'Pong-Time', 5, 18, 1, '2023-10-26', '2023-09-06', 1, 25);

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
                               `id_utilisateur` int(11) NOT NULL,
                               `courriel` varchar(100) NOT NULL,
                               `pseudo` varchar(100) NOT NULL,
                               `nom` varchar(100) NOT NULL,
                               `prenom` varchar(100) NOT NULL,
                               `motDePasse` varchar(150) NOT NULL,
                               `estActif` tinyint(1) NOT NULL,
                               `estOrganisateur` tinyint(1) DEFAULT NULL,
                               `urlPhoto` varbinary(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`id_utilisateur`, `courriel`, `pseudo`, `nom`, `prenom`, `motDePasse`, `estActif`, `estOrganisateur`, `urlPhoto`) VALUES
                                                                                                                                                 (20, 'louislayton@gmail.com', 'LouisL', 'Layton', 'Louis', '2a35800423c9585d3e2f58ad0b08a9883befc6696facdd10a1a3620277bbbd03ce5021811a2e72e5b890227458ff19143d1e3a11a308b43fef29c3d27a17d246', 1, 0, 0x2e2f75706c6f6164732f363436363130313038663531642e6a7067),
                                                                                                                                                 (25, 'n.claus@student.helmo.be', 'NoahClaus', 'Claus', 'Noah', 'ef3f42ce8556356759a04a6c4c471540616a26e6eea19b2e303e38ffed4062a503d975d0455bc04d1692bd6331e6e6dd35600c3c3496dbda4b5b1a7986888bf2', 1, 1, 0x2e2f75706c6f6164732f363436363036623232373631322e6a7067);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Participer`
--
ALTER TABLE `Participer`
    ADD PRIMARY KEY (`id_utilisateur`,`id_tournoi`),
  ADD KEY `id_tournoi` (`id_tournoi`);

--
-- Index pour la table `Rencontre`
--
ALTER TABLE `Rencontre`
    ADD PRIMARY KEY (`id_rencontre`,`id_tournoi`),
  ADD KEY `id_joueurUn` (`id_joueurUn`),
  ADD KEY `id_joueurDeux` (`id_joueurDeux`),
  ADD KEY `id_vainqueur` (`id_vainqueur`),
  ADD KEY `id_rencontre_suivante` (`id_rencontreSuivante`),
  ADD KEY `id_tournoi` (`id_tournoi`);

--
-- Index pour la table `Sport`
--
ALTER TABLE `Sport`
    ADD PRIMARY KEY (`id_sport`);

--
-- Index pour la table `Statut`
--
ALTER TABLE `Statut`
    ADD PRIMARY KEY (`id_statut`);

--
-- Index pour la table `Tournoi`
--
ALTER TABLE `Tournoi`
    ADD PRIMARY KEY (`id_tournoi`),
  ADD UNIQUE KEY `nom` (`nom`),
  ADD KEY `id_organisateur` (`id_organisateur`),
  ADD KEY `id_sport` (`id_sport`),
  ADD KEY `statut` (`statut`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
    ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `courriel` (`courriel`,`pseudo`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Rencontre`
--
ALTER TABLE `Rencontre`
    MODIFY `id_rencontre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT pour la table `Tournoi`
--
ALTER TABLE `Tournoi`
    MODIFY `id_tournoi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
    MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Participer`
--
ALTER TABLE `Participer`
    ADD CONSTRAINT `Participer_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `Utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `Participer_ibfk_2` FOREIGN KEY (`id_tournoi`) REFERENCES `Tournoi` (`id_tournoi`);

--
-- Contraintes pour la table `Rencontre`
--
ALTER TABLE `Rencontre`
    ADD CONSTRAINT `Rencontre_ibfk_1` FOREIGN KEY (`id_joueurUn`) REFERENCES `Utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `Rencontre_ibfk_2` FOREIGN KEY (`id_joueurDeux`) REFERENCES `Utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `Rencontre_ibfk_3` FOREIGN KEY (`id_vainqueur`) REFERENCES `Utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `Rencontre_ibfk_4` FOREIGN KEY (`id_rencontreSuivante`) REFERENCES `Rencontre` (`id_rencontre`),
  ADD CONSTRAINT `Rencontre_ibfk_5` FOREIGN KEY (`id_tournoi`) REFERENCES `Tournoi` (`id_tournoi`);

--
-- Contraintes pour la table `Tournoi`
--
ALTER TABLE `Tournoi`
    ADD CONSTRAINT `Tournoi_ibfk_1` FOREIGN KEY (`id_organisateur`) REFERENCES `Utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `Tournoi_ibfk_2` FOREIGN KEY (`statut`) REFERENCES `Statut` (`id_statut`),
  ADD CONSTRAINT `Tournoi_ibfk_3` FOREIGN KEY (`id_sport`) REFERENCES `Sport` (`id_sport`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
