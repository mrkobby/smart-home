-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2018 at 05:55 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smarthome`
--

-- --------------------------------------------------------

--
-- Table structure for table `dht11`
--

CREATE TABLE `dht11` (
  `id` int(11) NOT NULL,
  `temperature` varchar(20) NOT NULL,
  `humidity` varchar(20) NOT NULL,
  `fan_State` varchar(20) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dht11`
--

INSERT INTO `dht11` (`id`, `temperature`, `humidity`, `fan_State`, `time`) VALUES
(1161, '31', '95', '', '2018-07-07 15:26:08'),
(1162, '31', '95', '', '2018-07-07 15:26:18'),
(1163, '31', '95', '', '2018-07-07 15:26:29'),
(1164, '31', '95', '', '2018-07-07 15:26:39'),
(1165, '31', '95', '', '2018-07-07 15:26:49'),
(1166, '31', '95', '', '2018-07-07 15:27:00'),
(1167, '31', '95', '', '2018-07-07 15:27:10'),
(1168, '31', '95', '', '2018-07-07 15:27:21'),
(1169, '31', '95', '', '2018-07-07 15:27:31'),
(1170, '31', '95', '', '2018-07-07 15:27:42'),
(1171, '31', '95', '', '2018-07-07 15:27:52'),
(1172, '31', '95', '', '2018-07-07 15:28:03'),
(1173, '31', '95', '', '2018-07-07 15:28:13'),
(1174, '31', '95', '', '2018-07-07 15:28:24'),
(1175, '31', '95', '', '2018-07-07 15:28:34'),
(1176, '31', '95', '', '2018-07-07 15:28:45'),
(1177, '31', '95', '', '2018-07-07 15:28:55'),
(1178, '32', '95', '', '2018-07-07 15:29:06'),
(1179, '32', '95', '', '2018-07-07 15:29:16'),
(1180, '32', '95', '', '2018-07-07 15:29:27'),
(1181, '32', '95', '', '2018-07-07 15:29:37'),
(1182, '32', '95', '', '2018-07-07 15:29:47'),
(1183, '32', '95', '', '2018-07-07 15:29:58'),
(1184, '32', '95', '', '2018-07-07 15:30:08'),
(1185, '32', '95', '', '2018-07-07 15:30:19'),
(1186, '31', '95', '', '2018-07-07 15:30:29'),
(1187, '31', '95', '', '2018-07-07 15:30:40'),
(1188, '31', '95', '', '2018-07-07 15:30:50'),
(1189, '32', '95', '', '2018-07-07 15:31:00');

-- --------------------------------------------------------

--
-- Table structure for table `light`
--

CREATE TABLE `light` (
  `id` int(11) NOT NULL,
  `lightState` varchar(6) NOT NULL,
  `time` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `id` int(11) NOT NULL,
  `type` enum('U','A') NOT NULL DEFAULT 'U',
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(16) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `last_login_date` datetime NOT NULL,
  `ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`id`, `type`, `name`, `username`, `password`, `creation_date`, `last_login_date`, `ip`) VALUES
(1, 'A', 'admin', 'admin', 'admin', '2018-05-21 13:59:37', '2018-07-06 16:51:25', '1'),
(2, 'A', 'Wisdom Gohoho', 'sniper', 'admin', '2018-05-21 14:07:23', '2018-05-29 14:03:28', '1'),
(3, 'U', 'Daniel Dela', 'dollarsMe', 'dollarsMe@2000', '2018-05-21 16:56:02', '2018-05-22 11:42:01', '1'),
(4, 'U', 'Kwabena Dougan', 'mtc', 'admin', '2018-06-20 22:32:19', '0000-00-00 00:00:00', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dht11`
--
ALTER TABLE `dht11`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `light`
--
ALTER TABLE `light`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`username`,`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dht11`
--
ALTER TABLE `dht11`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1190;

--
-- AUTO_INCREMENT for table `light`
--
ALTER TABLE `light`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
