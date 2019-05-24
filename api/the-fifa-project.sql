-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 24 mei 2019 om 11:03
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
  `score_team1` int(11) NOT NULL,
  `score_team2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `teams`
--

CREATE TABLE `teams` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(30) NOT NULL,
  `owner` int(11) UNSIGNED NOT NULL,
  `goals` int(11) UNSIGNED NOT NULL,
  `wins` int(11) UNSIGNED NOT NULL,
  `loses` int(11) UNSIGNED NOT NULL,
  `created-at` datetime NOT NULL,
  `edit-at` datetime NOT NULL,
  `entered` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `teams`
--

INSERT INTO `teams` (`id`, `name`, `owner`, `goals`, `wins`, `loses`, `created-at`, `edit-at`, `entered`) VALUES
(2, 'hyhu', 4, 0, 0, 0, '2019-05-13 09:12:57', '0000-00-00 00:00:00', NULL),
(5, 'Fighters', 6, 0, 0, 0, '2019-05-14 12:44:01', '0000-00-00 00:00:00', NULL),
(6, 'kjoele mese', 6, 0, 0, 0, '2019-05-14 12:44:08', '0000-00-00 00:00:00', NULL),
(10, 'gugk', 1, 0, 0, 0, '2019-05-15 11:50:14', '0000-00-00 00:00:00', NULL),
(11, 'pietertjeas', 6, 0, 0, 0, '2019-05-16 09:20:56', '0000-00-00 00:00:00', NULL),
(12, 'kjfskjls', 1, 0, 0, 0, '2019-05-16 11:19:40', '0000-00-00 00:00:00', NULL),
(13, 'kaasknabbels V2', 1, 0, 0, 0, '2019-05-21 16:53:25', '0000-00-00 00:00:00', NULL),
(14, 'knappelkutjes', 1, 0, 0, 0, '2019-05-22 10:15:37', '0000-00-00 00:00:00', NULL);

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
(1, 'Glenn', '', 'Meering', 'glenn.dev@hotmail.com', '$2y$10$DKozezDEPR5nc3dXS3ArIuLCRDBRVAplRD3WHTw3im97hp5OzRjy2', NULL, 1, '2019-04-18 10:51:52'),
(2, 'kakie', '', 'dorp', 'dropje@kakje.nl', '$2y$10$RhTyfEh7wDZBz1DkVAMfHuvD6pDPNfb6oWtDFCcKjV0hWxiV1xU2C', NULL, NULL, '2019-05-09 09:00:10'),
(3, 'Mohammed', '123', 'Kabalan', 'hamadashow@outlook.com', '$2y$10$ZyOLe3l3SmE22LA.fuGJP.KS5fi8wzK/5XHWkEkTENBnrTWbWRioG', NULL, NULL, '2019-05-09 10:17:13'),
(4, 'ddsadas', '', 'dsadsadsa', 'dsadas@dsdsadsa.nl', '$2y$10$ke6gw5PUkN.z8JMCFRTy7.Kdvr6yGGMyV9jI9wLB4v19d5xuWNlkq', NULL, NULL, '2019-05-13 08:57:26'),
(5, 'Mohammed', '', 'Kabalan', 'hamadakabalan@gmail.com', '$2y$10$NQmNT.CPkOSPgpCzi4ekZO9U9B8WNIWPJ2hv04TN/LmCAxyOzHZ02', NULL, NULL, '2019-05-14 09:14:12'),
(6, 'Pietje', 'de', 'pannenkoek', 'pietje@hotmail.com', '$2y$10$7LkKRAIY83KiARTv8eKp8OWd1aMoLiWmdayOI3ZcT8n/XqQNaZLDG', NULL, NULL, '2019-05-16 09:20:09'),
(7, 'dskadk', 'dsjakdjska', 'djksajdksak', 'jdskdjska@jdskadksa.nl', '$2y$10$MFz/1avJp5.0GLIIwba9hePnscunmH9FIr.DRwYv4ahc1a9F.Mzla', NULL, NULL, '2019-05-22 10:17:26');

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
(1, 1, 2);

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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `user_team`
--
ALTER TABLE `user_team`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
