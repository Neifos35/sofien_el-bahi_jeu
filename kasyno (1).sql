-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 11 avr. 2024 à 11:46
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `kasyno`
--

-- --------------------------------------------------------

--
-- Structure de la table `friendship`
--

CREATE TABLE `friendship` (
  `id` int(11) NOT NULL,
  `user_id1` int(11) NOT NULL,
  `user_id2` int(11) NOT NULL,
  `statut` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `friendship`
--

INSERT INTO `friendship` (`id`, `user_id1`, `user_id2`, `statut`) VALUES
(18, 3, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `player1_id` int(11) NOT NULL,
  `player2_id` int(11) DEFAULT NULL,
  `state` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `winner_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `games`
--

INSERT INTO `games` (`id`, `player1_id`, `player2_id`, `state`, `active`, `winner_id`, `created_at`, `updated_at`) VALUES
(4, 2, NULL, 'waiting', 1, NULL, '2024-03-30 16:37:54', '2024-03-30 16:37:54'),
(5, 2, NULL, 'waiting', 1, NULL, '2024-03-30 16:44:01', '2024-03-30 16:44:01'),
(6, 2, NULL, 'waiting', 1, NULL, '2024-03-30 16:44:04', '2024-03-30 16:44:04'),
(7, 2, NULL, 'waiting', 1, NULL, '2024-03-30 16:45:52', '2024-03-30 16:45:52'),
(8, 2, 3, 'started', 1, NULL, '2024-03-30 16:46:16', '2024-03-31 14:01:26'),
(9, 2, 2, 'started', 1, NULL, '2024-03-30 16:46:21', '2024-04-01 09:44:22'),
(10, 2, 3, 'started', 1, NULL, '2024-03-30 16:47:15', '2024-04-01 14:40:20'),
(11, 2, NULL, 'waiting', 1, NULL, '2024-03-30 16:47:16', '2024-03-30 16:47:16'),
(12, 2, NULL, 'waiting', 1, NULL, '2024-03-30 16:47:17', '2024-03-30 16:47:17'),
(13, 2, NULL, 'waiting', 1, NULL, '2024-03-30 16:47:27', '2024-03-30 16:47:27'),
(14, 2, 2, 'started', 1, NULL, '2024-03-30 16:53:50', '2024-04-06 12:47:34'),
(15, 2, NULL, 'waiting', 1, NULL, '2024-03-30 16:56:32', '2024-03-30 16:56:32'),
(16, 2, NULL, 'waiting', 1, NULL, '2024-03-30 17:00:27', '2024-03-30 17:00:27'),
(17, 2, 2, 'started', 1, NULL, '2024-03-30 17:02:23', '2024-04-06 12:48:17'),
(18, 2, NULL, 'waiting', 1, NULL, '2024-03-30 17:59:48', '2024-03-30 17:59:48'),
(19, 2, NULL, 'waiting', 1, NULL, '2024-03-31 09:50:45', '2024-03-31 09:50:45'),
(20, 2, NULL, 'waiting', 1, NULL, '2024-03-31 09:55:13', '2024-03-31 09:55:13'),
(21, 2, NULL, 'waiting', 1, NULL, '2024-03-31 10:07:03', '2024-03-31 10:07:03'),
(22, 2, NULL, 'waiting', 1, NULL, '2024-03-31 10:11:33', '2024-03-31 10:11:33');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `password` char(255) NOT NULL,
  `soldeFictif` int(11) NOT NULL DEFAULT 5000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `username`, `mail`, `password`, `soldeFictif`) VALUES
(1, 'Sofien', 'Sofien', 'Sofien', 'finder@findermail.com', '$2y$10$dSwAqoCo2hMPEDHmKL3l6uTzi4byIismX/qaHCKsxxo4y0TjQEy0q', 5000),
(2, 'Sofien2', 'Sofien2', 'Sofien2', 's@mail.fr', '$2y$10$iIxR2u/dZ5m/sjPfOFjvLeFZNckbHC1RgXP6fu8.okybSLUp19wBC', 5000),
(3, 'G', 'Mael', 'maelg', 'mael@mail.fr', '$2y$10$uOoB87zRPZVDQm8XaOULYu76KJFe1BrYEzgjzIQ5hkgESVCQpwDk6', 5000);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `friendship`
--
ALTER TABLE `friendship`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_friendship` (`user_id1`,`user_id2`),
  ADD KEY `user_id2` (`user_id2`);

--
-- Index pour la table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD KEY `player1_id` (`player1_id`),
  ADD KEY `player2_id` (`player2_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `friendship`
--
ALTER TABLE `friendship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `friendship`
--
ALTER TABLE `friendship`
  ADD CONSTRAINT `friendship_ibfk_1` FOREIGN KEY (`user_id1`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `friendship_ibfk_2` FOREIGN KEY (`user_id2`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `games`
--
ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_1` FOREIGN KEY (`player1_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `games_ibfk_2` FOREIGN KEY (`player2_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
