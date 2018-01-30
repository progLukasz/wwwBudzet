-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 09 Sty 2018, 19:38
-- Wersja serwera: 10.1.26-MariaDB
-- Wersja PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `budzetdomowy`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cathegories`
--

CREATE TABLE `cathegories` (
  `CathegoryID` int(11) NOT NULL,
  `Name` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses`
--

CREATE TABLE `expenses` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `CathegoryID` int(11) NOT NULL,
  `PayMetID` int(11) NOT NULL,
  `Value` float NOT NULL,
  `Date` date NOT NULL,
  `Comment` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `paymentmethod`
--

CREATE TABLE `paymentmethod` (
  `PayMetID` int(11) NOT NULL,
  `Name` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `summary`
--

CREATE TABLE `summary` (
  `ID` int(11) NOT NULL,
  `CathegoryID` int(11) NOT NULL,
  `Summary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `unactivatedusers`
--

CREATE TABLE `unactivatedusers` (
  `Token` text NOT NULL,
  `Login` text NOT NULL,
  `Email` text NOT NULL,
  `Password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Login` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Email` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Password` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `IsAdmin` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`UserID`, `Login`, `Email`, `Password`, `IsAdmin`, `Date`) VALUES
(3, 'Osoba1', 'osoba1@wp.pl', '$2y$10$yitsj4dAY/uHu61xmSUVrOoFNtg4ycy1uCzfiCtIrPcp754lHlBKq', 'No', '2018-01-09 18:33:53'),
(4, 'Osoba2', 'osoba2@o2.pl', '$2y$10$yitsj4dAY/uHu61xmSUVrOoFNtg4ycy1uCzfiCtIrPcp754lHlBKq', 'No', '2018-01-09 00:00:00');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `cathegories`
--
ALTER TABLE `cathegories`
  ADD PRIMARY KEY (`CathegoryID`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `paymentmethod`
--
ALTER TABLE `paymentmethod`
  ADD PRIMARY KEY (`PayMetID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `cathegories`
--
ALTER TABLE `cathegories`
  MODIFY `CathegoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT dla tabeli `expenses`
--
ALTER TABLE `expenses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT dla tabeli `paymentmethod`
--
ALTER TABLE `paymentmethod`
  MODIFY `PayMetID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
