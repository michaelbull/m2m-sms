-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jan 14, 2015 at 04:22 PM
-- Server version: 5.5.38
-- PHP Version: 5.5.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `circuitboard_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `board_info`
--

DROP TABLE IF EXISTS `board_info`;
CREATE TABLE `board_info` (
  `msisdn` varchar(15) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `board_info`
--

-- --------------------------------------------------------

--
-- Table structure for table `board_status`
--

DROP TABLE IF EXISTS `board_status`;
CREATE TABLE `board_status` (
  `msisdn` varchar(15) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `switchOne` enum('OFF','ON') NOT NULL,
  `switchTwo` enum('OFF','ON') NOT NULL,
  `switchThree` enum('OFF','ON') NOT NULL,
  `switchFour` enum('OFF','ON') NOT NULL,
  `fan` enum('FORWARD','REVERSE') NOT NULL,
  `temperature` int(3) NOT NULL,
  `keypad` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `board_status`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `rank` enum('USER','ADMIN') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `board_info`
--
ALTER TABLE `board_info`
ADD PRIMARY KEY (`msisdn`);

--
-- Indexes for table `board_status`
--
ALTER TABLE `board_status`
ADD PRIMARY KEY (`msisdn`), ADD KEY `msisdn` (`msisdn`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `board_status`
--
ALTER TABLE `board_status`
ADD CONSTRAINT `board_status_ibfk_1` FOREIGN KEY (`msisdn`) REFERENCES `board_info` (`msisdn`);
