-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 19, 2011 at 10:48 AM
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
DROP DATABASE `aeolus`;
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
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `verified` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `incidents`
--

INSERT INTO `incidents` (`title`, `description`, `id`, `latitude`, `longitude`, `verified`) VALUES
('Testtitle', 'This is the test description', 1, -34.397, 150.644, 1),
('trdfg', 'sdg', 2, -35.397, 150.644, 1),
('fdsg', 'sdfg', 3, -33.27, 151.792, 0),
('hello', 'test', 4, -33.2792, 149.595, 1),
('rwer', 'wer', 5, -23.0333, 145.969, 1),
('tertsfg', 'sdg', 6, -24.225, 148.881, 0),
('wohoo', 'test', 7, -27.6622, 152.924, 0);

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
  `clock_in_time` timestamp NULL DEFAULT NULL,
  `clock_out_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `role`, `clock_in_time`, `clock_out_time`) VALUES
(1, 'admin', '45d0122d11b30012eb0111b09181712f16620a7a', 'ce8d96d579d389e783f95b3772785783ea1a9854', 'admin', NULL, NULL);