-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
<<<<<<< HEAD
-- Generation Time: Sep 28, 2021 at 08:26 PM
=======
-- Generation Time: Sep 16, 2021 at 05:50 PM
>>>>>>> c57082d0c6c69e201649cbcec628332857d8a6f4
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_portty`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_boards`
--

CREATE TABLE `tbl_boards` (
  `id` int(11) NOT NULL,
  `board_name` varchar(128) NOT NULL,
  `board_desc` varchar(128) NOT NULL,
  `board_location` varchar(128) NOT NULL,
  `monitor_name` varchar(128) NOT NULL,
  `com_port` varchar(64) NOT NULL,
  `board_type` varchar(128) NOT NULL,
  `pins` varchar(20) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `temp` float NOT NULL,
  `hum` float NOT NULL,
  `refresh_sec` varchar(2) NOT NULL DEFAULT '3',
  `monitored` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dht`
--

CREATE TABLE `tbl_dht` (
  `id` int(11) NOT NULL,
  `board_name` varchar(128) NOT NULL,
  `temp` float NOT NULL,
  `hum` float NOT NULL,
  `dt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_limits`
--

CREATE TABLE `tbl_limits` (
  `indx` int(11) NOT NULL,
  `lim_num` int(2) NOT NULL,
  `board_name` varchar(128) NOT NULL,
  `lim_low` int(2) NOT NULL,
  `lim_hi` int(2) NOT NULL,
  `lim_trig_low` int(2) NOT NULL,
  `lim_trig_range` int(2) NOT NULL,
  `lim_trig_hi` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_monitors`
--

CREATE TABLE `tbl_monitors` (
  `id` int(11) NOT NULL,
  `monitor_name` varchar(128) NOT NULL,
  `monitor_type` varchar(128) NOT NULL,
  `monitor_desc` varchar(128) NOT NULL,
  `monitor_location` varchar(128) NOT NULL,
  `monitor_timezone` varchar(128) NOT NULL,
  `passcode` varchar(6) NOT NULL,
  `exe_dir` varchar(128) NOT NULL,
  `refresh_sec` int(2) NOT NULL DEFAULT 3,
  `active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pins`
--

CREATE TABLE `tbl_pins` (
  `id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `pin_num` int(2) NOT NULL,
  `pin_name` varchar(128) NOT NULL,
  `pin_desc` varchar(128) NOT NULL,
  `board_name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sensord`
--

CREATE TABLE `tbl_sensord` (
  `board_name` varchar(128) NOT NULL,
  `val1` float NOT NULL,
  `val2` float NOT NULL,
  `val3` float NOT NULL,
  `val4` float NOT NULL,
  `val5` float NOT NULL,
  `val6` float NOT NULL,
  `val7` float NOT NULL,
  `val8` float NOT NULL,
  `val9` float NOT NULL,
  `val10` float NOT NULL,
  `val11` float NOT NULL,
  `val12` float NOT NULL,
  `val13` float NOT NULL,
  `val14` float NOT NULL,
  `val15` float NOT NULL,
  `val16` float NOT NULL,
  `val17` float NOT NULL,
  `val18` float NOT NULL,
  `val19` float NOT NULL,
  `val20` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `user_email` varchar(128) NOT NULL,
  `user_mobile` varchar(24) NOT NULL,
  `dashboard_ip` varchar(24) NOT NULL,
  `filtered_pins` varchar(32) NOT NULL,
  `filtered_dht` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_boards`
--
ALTER TABLE `tbl_boards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `board_name` (`board_name`);

--
-- Indexes for table `tbl_dht`
--
ALTER TABLE `tbl_dht`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_limits`
--
ALTER TABLE `tbl_limits`
  ADD PRIMARY KEY (`indx`);

--
-- Indexes for table `tbl_monitors`
--
ALTER TABLE `tbl_monitors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pins`
--
ALTER TABLE `tbl_pins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_boards`
--
ALTER TABLE `tbl_boards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_dht`
--
ALTER TABLE `tbl_dht`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_limits`
--
ALTER TABLE `tbl_limits`
  MODIFY `indx` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_monitors`
--
ALTER TABLE `tbl_monitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pins`
--
ALTER TABLE `tbl_pins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
