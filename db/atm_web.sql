-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2021 at 02:31 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `atm_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `iban` varchar(24) NOT NULL,
  `user_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `current_balance` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `iban`, `user_id`, `currency_id`, `current_balance`) VALUES
(1, 'RO82RZBR1243764245985223', 4, 1, 20),
(2, 'RO07EURCRT43674378431523', 4, 2, 2648),
(5, 'Rjqz5VepyrJjHEThD1GOljv8', 4, 3, 12345),
(6, 'o7COz5ia1cLgwBzIvnikHV7V', 5, 2, 598),
(7, 'xK4HWn6aeEppqF5KTFuK8Uge', 6, 2, 149999990),
(8, '0p4sNxhylwRq3Qzm0kZLH8VT', 6, 1, 1),
(9, '291LSY0yXoT5DCnc9aYl0shM', 6, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `code` varchar(16) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `code`, `name`, `description`) VALUES
(1, 'RON', 'Leu', 'Romanian leu'),
(2, 'EUR', 'Euro', 'Euro'),
(3, 'USD', 'USD', 'United States Dollar');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `from_account_id` int(11) NOT NULL,
  `to_account_id` int(11) DEFAULT NULL,
  `value` double NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `type` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `from_account_id`, `to_account_id`, `value`, `date`, `type`) VALUES
(1, 6, NULL, 2, '2021-02-28', 'ADD'),
(2, 6, NULL, 10, '2021-02-28', 'ADD'),
(3, 6, NULL, 15, '2021-02-28', 'WITHDRAW'),
(4, 6, 1, 20, '2021-02-28', 'TRANSFER_WITHDRA'),
(5, 1, 6, 20, '2021-02-28', 'TRANSFER_ADD'),
(6, 7, NULL, 1, '2021-02-28', 'ADD'),
(7, 7, NULL, 2, '2021-02-28', 'WITHDRAW'),
(8, 7, NULL, 1, '2021-02-28', 'ADD'),
(9, 7, 2, 10, '2021-02-28', 'TRANSFER_WITHDRA'),
(10, 2, 7, 10, '2021-02-28', 'TRANSFER_ADD');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(64) NOT NULL,
  `last_name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`) VALUES
(1, 'Ion', 'Popescu', 'popescuion@email.com', 'parola'),
(2, 'Mihai', 'Eminescu', 'eminem@email.com', 'parola'),
(3, 'Radu', 'Petre', 'petreradu@email.com', 'parola'),
(4, 'first name', 'last name', 'test', 'test'),
(5, 'Alexandru', 'Ionescu', 'alex@email.com', 'parola'),
(6, 'a', 'b', 'a', 'b');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_uk` (`user_id`,`currency_id`),
  ADD KEY `accounts_currency_fk` (`currency_id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_from_acc_fk` (`from_account_id`),
  ADD KEY `transaction_to_acc_fk` (`to_account_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_currency_fk` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`),
  ADD CONSTRAINT `accounts_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transaction_from_acc_fk` FOREIGN KEY (`from_account_id`) REFERENCES `accounts` (`id`),
  ADD CONSTRAINT `transaction_to_acc_fk` FOREIGN KEY (`to_account_id`) REFERENCES `accounts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
