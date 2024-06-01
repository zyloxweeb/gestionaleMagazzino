-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 28, 2024 alle 18:06
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Impostazioni del set di caratteri
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `warehouse`
--

-- --------------------------------------------------------

-- Struttura della tabella `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Acque'),
(2, 'Analcoliche'),
(3, 'Liquori'),
(4, 'Birre'),
(5, 'Vini');

-- --------------------------------------------------------

-- Struttura della tabella `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `lot_number` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `type` enum('bottiglia','lattina','fusto') NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `products`
--

INSERT INTO `products` (`id`, `name`, `expiry_date`, `lot_number`, `image`, `quantity`, `price`, `type`, `category_id`) VALUES
(1, 'Acqua Minerale', '2024-12-31', 'LOT12345', 'acqua_minerale.jpg', 70, 0.00, 'bottiglia', 1),
(2, 'Cola', '2024-08-15', 'LOT12346', 'cola.jpg', 50, 1.20, 'lattina', 2),
(3, 'Vodka', '2025-05-30', 'LOT12347', 'vodka.jpg', 20, 15.00, 'bottiglia', 3),
(4, 'Birra Artigianale', '2024-07-20', 'LOT12348', 'birra.jpg', 75, 3.50, 'fusto', 4),
(5, 'Vino Rosso', '2026-11-10', 'LOT12349', 'vino_rosso.jpg', 30, 10.00, 'bottiglia', 5),
(6, 'Levissima', '2024-05-31', 'LOT12345', 'levissima.jpeg', 10, 0.75, 'bottiglia', 1);

-- --------------------------------------------------------

-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(7, 'admin', '$2y$10$b5OHYxEe2K8PNy6yC9ld7ODpzxfGvIGX/SuoKupRYREmj1EVuBkw6', 'admin'),
(8, 'user1', '$2y$10$7s8O9l5E1g/J2.Bofsl2Q.8W8g8plRppL.9uY7HYwCQwzI.R6OqIu', 'user');

-- Indici per le tabelle scaricate
--

-- Indici per la tabella `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

-- Indici per la tabella `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

-- Indici per la tabella `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

-- AUTO_INCREMENT per le tabelle scaricate
--

-- AUTO_INCREMENT per la tabella `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

-- AUTO_INCREMENT per la tabella `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

-- Limiti per le tabelle scaricate
--

-- Limiti per la tabella `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
