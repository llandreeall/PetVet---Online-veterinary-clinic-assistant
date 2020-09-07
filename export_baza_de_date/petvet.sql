-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: ian. 17, 2020 la 03:31 PM
-- Versiune server: 10.4.10-MariaDB
-- Versiune PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `petvet`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `fisa_medicala`
--

CREATE TABLE `fisa_medicala` (
  `id` int(10) UNSIGNED NOT NULL,
  `afectiune` varchar(100) NOT NULL,
  `data` date NOT NULL,
  `id_pacient` int(10) UNSIGNED NOT NULL,
  `id_medicament` int(10) UNSIGNED NOT NULL,
  `id_interventie` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `fisa_medicala`
--

INSERT INTO `fisa_medicala` (`id`, `afectiune`, `data`, `id_pacient`, `id_medicament`, `id_interventie`) VALUES
(1, 'Raceala', '2020-01-07', 5, 1, 0),
(2, 'Greata', '2020-01-23', 8, 2, 0),
(3, 'Sterilizare ceruta de catre pr', '2020-01-18', 5, 7, 2),
(4, 'Control regulat', '2020-01-12', 8, 0, 3),
(5, 'Coada rupta in varf', '2019-12-12', 8, 7, 4);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `interventii`
--

CREATE TABLE `interventii` (
  `id` int(10) UNSIGNED NOT NULL,
  `denumire` varchar(30) NOT NULL,
  `descriere` text NOT NULL,
  `pret` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `interventii`
--

INSERT INTO `interventii` (`id`, `denumire`, `descriere`, `pret`) VALUES
(2, 'Sterilizare', 'In urma interventiei pacientul nu mai poate face pui.', 100),
(3, 'Vaccin', 'Vaccin periodic', 150),
(4, 'Interventie de Urgenta', 'In urma unui accident se recurge la interventia de urgenta.', 0),
(8, 'Deparazitare', 'Aplicarea unor pudre speciale pentru paraziti si a unor injectii', 50);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `login_tokens`
--

CREATE TABLE `login_tokens` (
  `id` int(10) UNSIGNED NOT NULL,
  `token` char(64) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `login_tokens`
--

INSERT INTO `login_tokens` (`id`, `token`, `user_id`) VALUES
(25, '62bb7b9a03a4f3be20f2a952564e1ca7ebe72d04', 7);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `medicamente`
--

CREATE TABLE `medicamente` (
  `id` int(10) UNSIGNED NOT NULL,
  `denumire` varchar(30) NOT NULL,
  `descriere` text NOT NULL,
  `bucati` int(10) UNSIGNED NOT NULL,
  `specie_destinata` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `medicamente`
--

INSERT INTO `medicamente` (`id`, `denumire`, `descriere`, `bucati`, `specie_destinata`) VALUES
(1, 'Paracetamol', 'Pentru raceala', 60, 'toate'),
(2, 'Metoclopramid', 'Pentru greata', 10, 'caine'),
(3, 'Paracetamol_P', 'Paracetamol pentru Pisici - Pentru raceala', 40, 'pisica'),
(7, 'Anestezie ', 'Se foloseste pentru interventii unde pacientul trebuie sa fie inconstient.', 100, 'toate');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `medici`
--

CREATE TABLE `medici` (
  `id` int(10) UNSIGNED NOT NULL,
  `nume` varchar(30) NOT NULL,
  `prenume` varchar(30) NOT NULL,
  `cnp` varchar(13) NOT NULL,
  `username` varchar(32) NOT NULL,
  `parola` varchar(64) NOT NULL,
  `specializare` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `medici`
--

INSERT INTO `medici` (`id`, `nume`, `prenume`, `cnp`, `username`, `parola`, `specializare`) VALUES
(7, 'Negoita', 'Andreea', '1111111111111', 'andreea', '$2y$10$xqlvRV9n6trIReG9qGksg.Rjs7yZK4uyxWAXR9QCGBNJRY1PJX0q2', 'andreea'),
(8, 'Petrea', 'Ana', '2990519123456', 'anamaria', '$2y$10$Dsk3fzHh5dm96XGq1YPg8ustbb0AOkg31T/8d8gH0URk6e0Qs3M4i', 'Oi'),
(9, 'Daniela', 'Manole', '2222222222222', 'danielamanole', '$2y$10$zcnCyIXG.2bub.7IqofOtO004EtCpoCbt4.0PW5Uy7rmh./NLOkN6', 'Pasari'),
(12, 'Stoica', 'Florentina', '3333333333333', 'florentina', '$2y$10$yPv812GD5eYr0kPDjTRmAueC//EzRm5r14boZ2jz.KYuJehDbIY7i', 'General');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `medici_interventii`
--

CREATE TABLE `medici_interventii` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_medic` int(10) UNSIGNED NOT NULL,
  `id_interventie` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `medici_interventii`
--

INSERT INTO `medici_interventii` (`id`, `id_medic`, `id_interventie`) VALUES
(2, 7, 2),
(3, 7, 3),
(9, 7, 4),
(11, 7, 8),
(5, 8, 2),
(4, 8, 4),
(7, 9, 3),
(6, 9, 4),
(10, 12, 8);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `pacienti`
--

CREATE TABLE `pacienti` (
  `id` int(10) UNSIGNED NOT NULL,
  `nume` varchar(30) NOT NULL,
  `rasa` varchar(30) NOT NULL,
  `specie` varchar(30) NOT NULL,
  `id_proprietar` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `pacienti`
--

INSERT INTO `pacienti` (`id`, `nume`, `rasa`, `specie`, `id_proprietar`) VALUES
(5, 'Mitzi', 'pisica', 'pisica', 2),
(8, 'Doggo', 'caine', 'caine', 2),
(11, 'Azorel', 'caine', 'caine', NULL),
(14, 'Coco', 'African', 'Papagal', 7);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `proprietari`
--

CREATE TABLE `proprietari` (
  `id` int(10) UNSIGNED NOT NULL,
  `nume` varchar(30) NOT NULL,
  `prenume` varchar(30) NOT NULL,
  `cnp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Eliminarea datelor din tabel `proprietari`
--

INSERT INTO `proprietari` (`id`, `nume`, `prenume`, `cnp`) VALUES
(2, 'Mugur', 'Mugurel', '1234567891012'),
(4, 'Negoita', 'Geanina', '2998723104534'),
(7, 'Popa', 'Ioana', '2976534281763');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `fisa_medicala`
--
ALTER TABLE `fisa_medicala`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pacient` (`id_pacient`);

--
-- Indexuri pentru tabele `interventii`
--
ALTER TABLE `interventii`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `denumire` (`denumire`);

--
-- Indexuri pentru tabele `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexuri pentru tabele `medicamente`
--
ALTER TABLE `medicamente`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `medici`
--
ALTER TABLE `medici`
  ADD PRIMARY KEY (`id`);

--
-- Indexuri pentru tabele `medici_interventii`
--
ALTER TABLE `medici_interventii`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_medic` (`id_medic`,`id_interventie`),
  ADD KEY `id_interventie` (`id_interventie`);

--
-- Indexuri pentru tabele `pacienti`
--
ALTER TABLE `pacienti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_proprietar` (`id_proprietar`);

--
-- Indexuri pentru tabele `proprietari`
--
ALTER TABLE `proprietari`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `fisa_medicala`
--
ALTER TABLE `fisa_medicala`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pentru tabele `interventii`
--
ALTER TABLE `interventii`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pentru tabele `login_tokens`
--
ALTER TABLE `login_tokens`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pentru tabele `medicamente`
--
ALTER TABLE `medicamente`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pentru tabele `medici`
--
ALTER TABLE `medici`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pentru tabele `medici_interventii`
--
ALTER TABLE `medici_interventii`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pentru tabele `pacienti`
--
ALTER TABLE `pacienti`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pentru tabele `proprietari`
--
ALTER TABLE `proprietari`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `fisa_medicala`
--
ALTER TABLE `fisa_medicala`
  ADD CONSTRAINT `fisa_medicala_ibfk_1` FOREIGN KEY (`id_pacient`) REFERENCES `pacienti` (`id`);

--
-- Constrângeri pentru tabele `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD CONSTRAINT `login_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `medici` (`id`);

--
-- Constrângeri pentru tabele `medici_interventii`
--
ALTER TABLE `medici_interventii`
  ADD CONSTRAINT `medici_interventii_ibfk_1` FOREIGN KEY (`id_medic`) REFERENCES `medici` (`id`),
  ADD CONSTRAINT `medici_interventii_ibfk_2` FOREIGN KEY (`id_interventie`) REFERENCES `interventii` (`id`);

--
-- Constrângeri pentru tabele `pacienti`
--
ALTER TABLE `pacienti`
  ADD CONSTRAINT `pacienti_ibfk_1` FOREIGN KEY (`id_proprietar`) REFERENCES `proprietari` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
