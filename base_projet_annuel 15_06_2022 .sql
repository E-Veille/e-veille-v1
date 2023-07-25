-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 15 juin 2023 à 07:58
-- Version du serveur :  10.3.38-MariaDB-0ubuntu0.20.04.1
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `testprojet`
--

-- --------------------------------------------------------

--
-- Structure de la table `chats`
--

CREATE TABLE `chats` (
  `chat_id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `opened` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chats`
--

INSERT INTO `chats` (`chat_id`, `from_id`, `to_id`, `message`, `opened`, `created_at`) VALUES
(1, 2, 5, 'effef', 1, '2023-05-11 14:49:38'),
(2, 2, 5, 'bonsoir', 1, '2023-05-11 14:49:43'),
(3, 5, 2, 'edouard', 1, '2023-05-11 14:51:20'),
(4, 2, 5, 'gérard bouchard\n', 1, '2023-05-11 14:51:34'),
(5, 3, 2, 'youhouuuuuu\n', 1, '2023-05-11 18:02:36'),
(6, 2, 3, 'salope\n', 1, '2023-05-11 18:02:49'),
(7, 2, 3, 'zefzef', 1, '2023-05-11 18:02:51'),
(8, 2, 3, 'zfze', 1, '2023-05-11 18:02:53'),
(9, 2, 3, 'fef', 1, '2023-05-11 18:02:54'),
(10, 3, 2, 'zoubiboubiboubibou\n', 1, '2023-05-11 18:03:12'),
(11, 3, 2, 'lkjmmlj', 1, '2023-05-12 11:50:37'),
(12, 3, 2, 'quoicoubeh', 1, '2023-05-12 12:00:00'),
(13, 2, 3, 'feur\n', 1, '2023-05-12 12:00:05'),
(14, 2, 3, 'dvdv', 1, '2023-05-12 12:00:06'),
(15, 2, 3, 'ge e', 1, '2023-05-12 12:00:07'),
(16, 2, 3, 'gege', 1, '2023-05-12 12:00:08'),
(17, 2, 5, 't\'es gay', 0, '2023-05-15 09:03:51'),
(18, 2, 3, 'Sudo sj', 1, '2023-05-15 09:06:50'),
(19, 4, 2, 'sudo suce\n', 1, '2023-05-15 09:07:10'),
(20, 2, 3, 'Ktur', 1, '2023-05-15 09:07:41'),
(21, 3, 2, 'gay\n', 1, '2023-05-15 09:07:43'),
(22, 2, 3, 'Rjr', 1, '2023-05-15 09:07:46'),
(23, 3, 2, 'khkjngbkjhbn ', 1, '2023-05-15 09:07:49'),
(24, 2, 4, 'test', 0, '2023-05-15 09:11:24'),
(25, 2, 4, 'y', 0, '2023-05-15 09:11:26'),
(26, 2, 4, 'y', 0, '2023-05-15 09:11:27'),
(27, 2, 4, 'y', 0, '2023-05-15 09:11:28'),
(28, 2, 4, 'y', 0, '2023-05-15 09:11:29'),
(29, 2, 4, 'y', 0, '2023-05-15 09:11:30'),
(30, 2, 4, 'y', 0, '2023-05-15 09:11:31'),
(31, 2, 4, 'yuiyuiy', 0, '2023-05-15 09:11:34'),
(32, 3, 4, 'ùml', 1, '2023-05-24 10:35:11'),
(33, 3, 4, ';,:;,', 1, '2023-05-24 10:37:40'),
(34, 3, 4, 'lùml', 1, '2023-05-24 10:37:43'),
(35, 3, 4, 'lkj', 1, '2023-05-24 10:37:53'),
(36, 3, 4, 'mlkù', 1, '2023-05-24 10:38:02'),
(37, 3, 4, 'mk', 1, '2023-05-24 10:38:12'),
(38, 12, 3, 'Bonjour ph je suis un intervenant.', 1, '2023-05-26 10:06:20'),
(39, 3, 12, 'dzd', 0, '2023-06-14 10:26:32');

-- --------------------------------------------------------

--
-- Structure de la table `conversations`
--

CREATE TABLE `conversations` (
  `conversation_id` int(11) NOT NULL,
  `user_1` int(11) NOT NULL,
  `user_2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `conversations`
--

INSERT INTO `conversations` (`conversation_id`, `user_1`, `user_2`) VALUES
(1, 2, 5),
(2, 3, 2),
(3, 4, 2),
(4, 3, 4),
(5, 12, 3);

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `reactions` int(11) NOT NULL DEFAULT 0,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `post_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `content`, `user_id`, `reactions`, `timestamp`, `post_type`) VALUES
(1, 'post 1', 'Voici un premier post !', 11, 0, '2023-05-27 11:38:04', 'texte'),
(2, 'Le menu de la cantine', 'Voici le menu du jour :<br />\r\n<br />\r\nOuvert ce midi et ce soir<br />\r\n<br />\r\nENTRÉE/PLAT OU PLAT /DESSERT<br />\r\n20,00 €<br />\r\n<br />\r\nENTRÉES<br />\r\nfoie gras de canard maison<br />\r\n21,50 €<br />\r\nTète de veau échalotes<br />\r\n15,50 €<br />\r\nPLATS<br />\r\nPièce de bœuf ( entrecote) et garnitures<br />\r\n19,50 €<br />\r\nFondant de pintadeau forestiere<br />\r\n19,50 €<br />\r\nDESSERTS<br />\r\nTerrine glacée aux pommes et Calvados<br />\r\n8,50 €<br />\r\nTarte aux citrons spéculoos maison<br />\r\n8,50 €', 11, 0, '2023-05-27 11:39:59', 'texte'),
(3, 'lorem', 'Qu&#039;est-ce que le Lorem Ipsum?<br />\r\nLe Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l&#039;imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n&#039;a pas fait que survivre cinq siècles, mais s&#039;est aussi adapté à la bureautique informatique, sans que son contenu n&#039;en soit modifié. Il a été popularisé dans les années 1960 grâce à la vente de feuilles Letraset contenant des passages du Lorem Ipsum, et, plus récemment, par son inclusion dans des applications de mise en page de texte, comme Aldus PageMaker.', 11, 0, '2023-05-27 11:40:20', 'texte'),
(4, 'Bonjour', 'Lancement de l\'application !', 2, 0, '2023-06-14 06:31:01', 'texte');

-- --------------------------------------------------------

--
-- Structure de la table `sondages`
--

CREATE TABLE `sondages` (
  `sondage_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `option` varchar(255) NOT NULL,
  `votes` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `p_p` varchar(255) DEFAULT 'user-default.png',
  `last_seen` datetime NOT NULL DEFAULT current_timestamp(),
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `reset` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `name`, `username`, `password`, `p_p`, `last_seen`, `role`, `reset`) VALUES
(2, 'admin', 'admin', '$2y$10$sb6IPHctC6PPFLBIfHScueMr2IaPVTgJr9LZy/Q.cQlvouiOEpL2.', 'user-default.png', '2023-06-14 08:48:31', 'admin', 0),
(3, 'ph', 'ph', '$2y$10$GhBT6UU70Uuelvbaby2sruNIrV/inbvXitFiWJNVQBE79BQzavnA6', 'user-default.png', '2023-06-14 10:26:35', 'user', 0),
(4, 'mathis', 'mathis', '$2y$10$HJF1CzKJ3mDHuEdkohw99.P5lrv4GRMnXncmP00JpyZyjE9vEoety', 'user-default.png', '2023-05-24 10:40:11', 'user', 0),
(5, 'edouard', 'edouard', '$2y$10$tKbAbTwL2nG1AfKeEWsFHeS647p8JBEpWArXttGVSOu0FUE49.9xG', 'user-default.png', '2023-05-24 07:38:15', 'user', 0),
(11, 'influenceur', 'influenceur', '$2y$10$plI1DPo0wevUkDWATgLRV.nIcjHo4zsjOo6vOhl5t9VENDC.Vszf2', 'user-default.png', '2023-05-26 10:03:28', 'influenceur', 0),
(12, 'intervenant', 'intervenant', '$2y$10$X/AHg6FEdn63DxETfLQIm.n6j/w0YoRIfw7MKQ0uFmT/aU3wecmC2', 'user-default.png', '2023-05-26 11:11:50', 'intervenant', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chat_id`);

--
-- Index pour la table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`conversation_id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `sondages`
--
ALTER TABLE `sondages`
  ADD PRIMARY KEY (`sondage_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chats`
--
ALTER TABLE `chats`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `conversation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Contraintes pour la table `sondages`
--
ALTER TABLE `sondages`
  ADD CONSTRAINT `sondages_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
