-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 10, 2011 at 11:05 AM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aeolus`
--
DROP DATABASE IF EXISTS `aeolus`;
CREATE DATABASE `aeolus` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `aeolus`;

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE IF NOT EXISTS `incidents` (
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `verified` tinyint(1) NOT NULL,
  `twitter_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=107 ;

--
-- Dumping data for table `incidents`
--

INSERT INTO `incidents` (`title`, `description`, `id`, `latitude`, `longitude`, `verified`, `twitter_id`) VALUES
('Tornado', 'A tornado is tearing through the southern suburbs', 10, -27.6914, 153.127, 0, NULL),
('Fire', 'There is a fire in brisbane city', 8, -27.5454, 152.924, 1, NULL),
('Flood', 'there is a flood in northern brisbane', 9, -27.3445, 152.993, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_incident`
--

CREATE TABLE IF NOT EXISTS `user_incident` (
  `user_id` int(11) NOT NULL,
  `incident_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`incident_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_incident`
--

INSERT INTO `user_incident` (`user_id`, `incident_id`) VALUES
(1, 10),
(6, 1),
(7, 10),
(8, 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL,
  `clock_in_time` bigint(20) DEFAULT NULL,
  `clock_out_time` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `role`, `clock_in_time`, `clock_out_time`) VALUES
(1, 'admin', '45d0122d11b30012eb0111b09181712f16620a7a', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'admin', 1304573907, 1304988341),
(7, 'bill cunnigham - fireman', '45d0122d11b30012eb0111b09181712f16620a7a', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'field_personell', NULL, NULL),
(8, 'james lear - policeman', '', '', 'guest', NULL, NULL),
(10, 'chleo tank - ambulance attendant', '', '', 'field_personell', NULL, NULL);