-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2023 at 12:51 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `irrigation`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` int(11) NOT NULL,
  `time` varchar(50) NOT NULL DEFAULT current_timestamp(),
  `temp` varchar(50) NOT NULL,
  `humid` varchar(20) NOT NULL,
  `moist` varchar(20) DEFAULT '',
  `manual_switch_stat` enum('ON','OFF') NOT NULL DEFAULT 'OFF',
  `pump_stat` enum('ON','OFF') NOT NULL DEFAULT 'OFF'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `time`, `temp`, `humid`, `moist`, `manual_switch_stat`, `pump_stat`) VALUES
(1, '2023-04-14 23:51:09', '78.00', '20.00', '98.00', 'ON', 'ON'),
(2, '2023-04-14 23:51:14', '78.00', '20.00', '99.00', 'ON', 'ON'),
(3, '2023-04-14 23:51:17', '78.00', '20.00', '99.00', 'ON', 'ON'),
(4, '2023-04-14 23:51:22', '78.00', '20.00', '99.00', 'ON', 'ON'),
(5, '2023-04-14 23:51:25', '78.00', '20.00', '99.00', 'ON', 'ON'),
(6, '2023-04-14 23:51:32', '78.00', '20.00', '98.00', 'ON', 'ON'),
(7, '2023-04-14 23:51:34', '78.00', '20.00', '99.00', 'ON', 'ON');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `user_type`, `password`) VALUES
(0, 'test', 't@gmail.com', 'admin', 'test');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
