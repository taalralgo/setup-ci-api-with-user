-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 11 août 2020 à 18:20
-- Version du serveur :  10.4.13-MariaDB
-- Version de PHP : 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gts_reservation`
--

-- --------------------------------------------------------

--
-- Structure de la table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL,
  `etat` int(11) NOT NULL DEFAULT 1,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `nom`, `prenom`, `email`, `password`, `role`, `etat`, `createdAt`) VALUES
(10, 'LY', 'Cherif', 'cherifly@gmail.com', 'passer1234', 'admin', 1, '2020-08-10 15:00:12'),
(11, 'THERA', 'Daouda', 'theradaouda@yahoo.com', 'kk', 'caissier', 0, '2020-08-11 09:25:20');

-- --------------------------------------------------------

--
-- Structure de la table `tbl_clients`
--

CREATE TABLE `tbl_clients` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `genre` varchar(8) NOT NULL,
  `cin` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_departs`
--

CREATE TABLE `tbl_departs` (
  `id` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  `trainId` int(11) NOT NULL,
  `lieuDepart` varchar(200) NOT NULL,
  `lieuArrive` varchar(200) NOT NULL,
  `placeAller` int(11) NOT NULL,
  `placeRetour` int(11) NOT NULL,
  `dateDepart` datetime NOT NULL,
  `arrivePrevu` datetime NOT NULL,
  `dateRetour` datetime NOT NULL,
  `retourPrevu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_laisserpasser`
--

CREATE TABLE `tbl_laisserpasser` (
  `id` int(11) NOT NULL,
  `eventId` int(11) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_reservations`
--

CREATE TABLE `tbl_reservations` (
  `id` int(11) NOT NULL,
  `clientId` int(11) NOT NULL,
  `typeReservation` varchar(15) NOT NULL,
  `departId` int(11) NOT NULL,
  `classe` varchar(250) NOT NULL,
  `trainId` int(11) NOT NULL,
  `voitureId` int(11) NOT NULL,
  `nbrePlace` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_trains`
--

CREATE TABLE `tbl_trains` (
  `id` int(11) NOT NULL,
  `libelle` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `tbl_voitures`
--

CREATE TABLE `tbl_voitures` (
  `id` int(11) NOT NULL,
  `train_id` int(11) NOT NULL,
  `libelle` varchar(200) NOT NULL,
  `nbre_place` int(11) NOT NULL,
  `classe` varchar(150) NOT NULL,
  `prix` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_clients`
--
ALTER TABLE `tbl_clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_departs`
--
ALTER TABLE `tbl_departs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_laisserpasser`
--
ALTER TABLE `tbl_laisserpasser`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_reservations`
--
ALTER TABLE `tbl_reservations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_trains`
--
ALTER TABLE `tbl_trains`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tbl_voitures`
--
ALTER TABLE `tbl_voitures`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `tbl_clients`
--
ALTER TABLE `tbl_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tbl_departs`
--
ALTER TABLE `tbl_departs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tbl_laisserpasser`
--
ALTER TABLE `tbl_laisserpasser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tbl_reservations`
--
ALTER TABLE `tbl_reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tbl_trains`
--
ALTER TABLE `tbl_trains`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `tbl_voitures`
--
ALTER TABLE `tbl_voitures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
