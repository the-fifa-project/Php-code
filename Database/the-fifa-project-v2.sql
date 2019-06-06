-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 06 jun 2019 om 09:27
-- Serverversie: 10.1.37-MariaDB
-- PHP-versie: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `the-fifa-project`
--
CREATE DATABASE IF NOT EXISTS `the-fifa-project` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `the-fifa-project`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `matches`
--

CREATE TABLE `matches` (
  `id` int(11) UNSIGNED NOT NULL,
  `team1` int(11) UNSIGNED NOT NULL,
  `team2` int(11) UNSIGNED NOT NULL,
  `time` time NOT NULL,
  `field` int(11) NOT NULL,
  `score_team1` int(11) DEFAULT NULL,
  `score_team2` int(11) DEFAULT NULL,
  `points_team1` int(11) UNSIGNED NOT NULL,
  `points_team2` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `matches`
--

INSERT INTO `matches` (`id`, `team1`, `team2`, `time`, `field`, `score_team1`, `score_team2`, `points_team1`, `points_team2`) VALUES
(1, 2, 3, '11:03:00', 1, NULL, NULL, 0, 0),
(2, 2, 4, '12:31:00', 2, NULL, NULL, 0, 0),
(3, 2, 6, '13:59:00', 3, NULL, NULL, 0, 0),
(4, 3, 4, '15:27:00', 4, NULL, NULL, 0, 0),
(5, 3, 6, '16:55:00', 5, NULL, NULL, 0, 0),
(6, 4, 6, '18:23:00', 1, NULL, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `settings`
--

CREATE TABLE `settings` (
  `id` int(11) UNSIGNED NOT NULL,
  `match_time` int(4) UNSIGNED NOT NULL,
  `half_time` int(4) UNSIGNED NOT NULL,
  `break_time` int(4) UNSIGNED NOT NULL,
  `fields` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `settings`
--

INSERT INTO `settings` (`id`, `match_time`, `half_time`, `break_time`, `fields`) VALUES
(1, 50, 18, 20, 4);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `teams`
--

CREATE TABLE `teams` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `owner` int(11) UNSIGNED NOT NULL,
  `points` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `created-at` datetime NOT NULL,
  `edit-at` datetime NOT NULL,
  `entered` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `teams`
--

INSERT INTO `teams` (`id`, `name`, `owner`, `points`, `created-at`, `edit-at`, `entered`) VALUES
(1, 'koekjes', 1, 0, '2019-05-27 14:02:03', '0000-00-00 00:00:00', NULL),
(2, 'pinda', 1, 4, '2019-05-27 14:02:12', '0000-00-00 00:00:00', 0),
(3, 'koeskoes', 1, 13, '2019-05-27 14:02:58', '0000-00-00 00:00:00', 0),
(4, 'Warriors of Pietje', 1, 0, '2019-06-04 12:44:42', '0000-00-00 00:00:00', 0),
(5, 'bhoe', 3, 0, '2019-06-04 13:00:49', '0000-00-00 00:00:00', NULL),
(6, 'kaassoufflee', 1, 0, '2019-06-04 13:38:52', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `administrator` tinyint(1) DEFAULT NULL,
  `dev_admin` tinyint(1) DEFAULT NULL,
  `registers_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `email`, `password`, `administrator`, `dev_admin`, `registers_date`) VALUES
(1, 'Glenn', '', 'Meering', 'glenn.dev@hotmail.com', '$2y$10$66gw5GHepj/75lhPq7643OuJU7b1jGZHytcKqAGKfwJAFPFyuZfC.', NULL, 1, '2019-05-27 12:35:56'),
(2, 'Donito', '', 'Renne', 'donitor@live.nl', '$2y$10$tZK35WhgYV4Rhadpnt64Iu4OX//JCK2OPexOxXnIek2ZK/6iJ5ae2', NULL, 1, '2019-05-27 12:37:28'),
(3, 'koen', '', 'altarita', 'koen@gmail.com', '$2y$10$Ti67BjM7dg0W0No1cZU0mu7xXdWkJ3oJoywti6BTwXUiPxoqRJsQC', NULL, NULL, '2019-06-04 08:45:53');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_team`
--

CREATE TABLE `user_team` (
  `id` int(11) UNSIGNED NOT NULL,
  `user` int(11) UNSIGNED NOT NULL,
  `team` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `user_team`
--

INSERT INTO `user_team` (`id`, `user`, `team`) VALUES
(1, 1, 1),
(2, 3, 1),
(3, 1, 2),
(4, 1, 3);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user_team`
--
ALTER TABLE `user_team`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `matches`
--
ALTER TABLE `matches`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `user_team`
--
ALTER TABLE `user_team`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
