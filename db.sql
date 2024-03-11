-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Lut 2024, 21:11
-- Wersja serwera: 10.4.25-MariaDB
-- Wersja PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `g5tabs`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `items`
--

CREATE TABLE `items` (
  `item` int(11) NOT NULL,
  `id_u` int(11) NOT NULL,
  `id_i` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `items`
--

INSERT INTO `items` (`item`, `id_u`, `id_i`) VALUES
(1, 2, 1),
(1, 2, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `styles`
--

CREATE TABLE `styles` (
  `id` int(11) NOT NULL,
  `name` varchar(65) NOT NULL,
  `description` varchar(250) NOT NULL,
  `hex1` varchar(7) NOT NULL,
  `hex2` varchar(7) NOT NULL,
  `hex3` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `styles`
--

INSERT INTO `styles` (`id`, `name`, `description`, `hex1`, `hex2`, `hex3`) VALUES
(1, 'Czerwony', 'Czy jesteś może gamerem?', '#090101', '#391212', '#d02d2d'),
(2, 'Hallowen', 'Boooo!', '#110803', '#40220d', '#f44906');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tabs`
--

CREATE TABLE `tabs` (
  `id` int(11) NOT NULL,
  `id_u` int(11) NOT NULL,
  `dane` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`dane`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `tabs`
--

INSERT INTO `tabs` (`id`, `id_u`, `dane`) VALUES
(9, 2, '{\"name\": \"Nowy Tab\", \"type\": 1, \"daty\": [{\"text\": \"przykladowy box\", \"data\": \"1 STY 2024\"}]}'),
(10, 2, '{\"name\": \"Nowy Tab\", \"type\": 1, \"daty\": [{\"text\": \"przykladowy box\", \"data\": \"1 STY 2024\"}]}'),
(11, 2, '{\"name\": \"Nowy Tab\", \"type\": 1, \"daty\": [{\"text\": \"przykladowy box\", \"data\": \"1 STY 2024\"}]}'),
(12, 2, '{\"name\": \"Nowy Tab\", \"type\": 1, \"daty\": [{\"text\": \"przykladowy box\", \"data\": \"1 STY 2024\"}]}'),
(13, 2, '{\"name\": \"Nowy Tab\", \"type\": 1, \"daty\": [{\"text\": \"przykladowy box\", \"data\": \"1 STY 2024\"}]}'),
(14, 2, '{\"name\": \"Nowy Tab\", \"type\": 1, \"daty\": [{\"text\": \"przykladowy box\", \"data\": \"1 STY 2024\"}]}'),
(15, 2, '{\"name\": \"Nowy Tab\", \"type\": 1, \"daty\": [{\"text\": \"przykladowy box\", \"data\": \"1 STY 2024\"}]}'),
(16, 2, '{\"name\": \"Nowy Tab\", \"type\": 1, \"daty\": [{\"text\": \"przykladowy box\", \"data\": \"1 STY 2024\"}]}'),
(17, 2, '{\"name\": \"Nowy Tab\", \"type\": 1, \"daty\": [{\"text\": \"przykladowy box\", \"data\": \"1 STY 2024\"}]}'),
(18, 2, '{\"name\": \"Nowy Tab\", \"type\": 1, \"daty\": [{\"text\": \"przykladowy box\", \"data\": \"1 STY 2024\"}]}');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_st` int(11) NOT NULL DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `id_st`) VALUES
(1, 'test', '$2y$10$KD.9g0w4ocZTGdZhuDMu6eb7Yo6sJrrM6TWX8shCWQYpXb5sdOJli', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `styles`
--
ALTER TABLE `styles`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `tabs`
--
ALTER TABLE `tabs`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `styles`
--
ALTER TABLE `styles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `tabs`
--
ALTER TABLE `tabs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
